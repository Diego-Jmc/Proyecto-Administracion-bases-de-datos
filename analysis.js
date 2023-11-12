const infoForm = document.getElementById('analysis-form')



function filterByHour(data){
    return data.filter(e=> e.HOUR >= 8 && e.HOUR <=20)
}


function getAvg(data) {
    const hoursArray = data.map(e => e.HOUR)
    
    const hoursPercentage = {}

    hoursArray.forEach(element => {
        if (element in hoursPercentage) {
            hoursPercentage[element]++
        } else {
            hoursPercentage[element] = 1
        }
    });

    const avgData = []

    for (let i = 8; i < 20; i++) {
        if (i in hoursPercentage) {
            let repetitions = hoursPercentage[i]
            let percentage = (repetitions / hoursArray.length) * 100

            avgData.push(Math.floor(percentage))
        } else {
            avgData.push(0)
        }
    }

    return avgData
}

function getCircularGraphInfo(data,hour){

    return getAvg(data,hour)
}

function getOverflowsNumber(data){
    return data.filter(e=> e.estado == 'Desbordamiento').length
}

infoForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const date1 = document.getElementById('fecha1').value;
    const date2 = document.getElementById('fecha2').value;

    if (date1 && date2) {
        const fecha1 = new Date(date1);
        const fecha2 = new Date(date2);

        if (fecha1 < fecha2) {
            const requestBody = {
                date1: `${fecha1.getFullYear()}-${fecha1.getMonth()}-${fecha1.getDay()}}`, 
                date2: `${fecha2.getFullYear()}-${fecha2.getMonth()}-${fecha2.getDay()}}`, 
            };
            fetch('http://localhost/monitor_memoria/services/hours', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestBody)
            })
            .then(response => response.json())
            .then(data => {

                console.log(data)
                
                const filtered = filterByHour(data)
                console.log(getAvg(filtered))
                showGraph(getAvg(filtered));
                updateExtraInfo(getOverflowsNumber(data),"")

            })
            .catch(error => {
                console.error('Error en la solicitud HTTP:', error);
            });
        } else {
            console.error('Error: Fecha1 debe ser menor que Fecha2');
        }
    } else {
        console.error('Error: Ambas fechas deben ser proporcionadas');
    }
});




// Función para mostrar el gráfico
function showGraph(data) {
    // Horas correspondientes a cada sección (formato de 24 horas)
    var hours = ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00'];

    // Configuración del tamaño del lienzo
    var width = 400;
    var height = 400;
    var radius = Math.min(width, height) / 2;

    // Configuración del arco para el gráfico circular
    var arc = d3.arc()
        .outerRadius(radius - 10)
        .innerRadius(0);

    // Configuración de la función que asigna colores a las secciones del gráfico
    var color = d3.scaleOrdinal(d3.schemeCategory10);

    // Seleccionar el elemento con el id "circular-grafics"
    var container = d3.select("#circular-grafics");

    // Crear el lienzo SVG dentro del contenedor
    var svg = container.append("svg")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

    // Crear los arcos basados en los datos
    var pie = d3.pie();
    var arcs = pie(data);

    // Agregar los arcos al lienzo
    svg.selectAll("path")
        .data(arcs)
        .enter().append("path")
        .attr("d", arc)
        .attr("fill", function(d, i) { return color(i); });

    // Agregar etiquetas de texto para las horas en el centro de cada sección
    svg.selectAll("text")
        .data(arcs)
        .enter().append("text")
        .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
        .attr("dy", "0.35em")
        .style("text-anchor", "middle")
        .text(function(d, i) { return hours[i]; });

        document.getElementById('circular-grafics-description').innerHTML="Promedio de picos de memoria segun las horas del dia."
 
}


function updateExtraInfo(overflows,hits){
    document.getElementById('overflows').innerHTML = `Numero de desbordamientos ocurridos: ${overflows}`

}


// Llamar a la función con datos de ejemplo
