const infoForm = document.getElementById('analysis-form')

function filterByHour(data){const daysArray = data.map(e => e.DAY);

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

function getCharBarAverage(data) {
    const daysArray = data.map(e => e.DAY);
    const usedArray = data.map(e => e.USED_MB);
    
    // Crear un objeto para almacenar la suma y el recuento para cada día de la semana
    const weeklyData = {
        0: { sum: 0, count: 0 }, // Lunes
        1: { sum: 0, count: 0 }, // Martes
        2: { sum: 0, count: 0 }, // Miércoles
        3: { sum: 0, count: 0 }, // Jueves
        4: { sum: 0, count: 0 }, // Viernes
        5: { sum: 0, count: 0 }, // Sábado
        6: { sum: 0, count: 0 }  // Domingo
    };

    
    // Iterar sobre los datos y acumular la suma y el recuento para cada día de la semana
    daysArray.forEach((dateString, index) => {
        const date = new Date(dateString);
        const dayOfWeek = date.getDay();
        const usedMB = parseFloat(usedArray[index]);
    
        // Acumular la suma y el recuento
        weeklyData[dayOfWeek].sum += usedMB;
        weeklyData[dayOfWeek].count += 1;
    });

    //console.log(weeklyData)
    
    // Calcular el promedio para cada día de la semana
    const averageData = Object.keys(weeklyData).map(dayOfWeek => {
        const dayData = weeklyData[dayOfWeek];
        const average = dayData.count > 0 ? dayData.sum / dayData.count : 0;
    
        return {
            dayOfWeek: parseInt(dayOfWeek),
            average: average
        };
    });
    

    //console.log(averageData)

    return averageData;
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
            const formatFecha = (fecha) => {
                const año = fecha.getFullYear();
                const mes = (fecha.getMonth() + 1).toString().padStart(2, '0');
                const dia = fecha.getDate().toString().padStart(2, '0');
                return `${año}-${mes}-${dia}`;
            }

            const requestBody = {
                date1: formatFecha(fecha1),
                date2: formatFecha(fecha2),
            };


            var url = new URL(window.location.href);

            var hostParam = url.searchParams.get('host');

            hostParam !== null ? url = `http://localhost/monitor_memoria/services/hours?host=${hostParam}` : url = "http://localhost/monitor_memoria/services/hours"

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestBody)
            })
            .then(response => response.json())
            .then(data => {

                showBarChart(getCharBarAverage(data))
                showCircularChart()
   

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




function showCircularChart(){


    // Horas correspondientes a cada sección (formato de 24 horas)
    var hours = ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00'];

    // Datos de prueba para 12 horas
    var data = [30, 20, 10, 25, 15, 30, 18, 22, 28, 35, 20, 15];

    // Configuración del tamaño del lienzo
    var width = 300;
    var height = 300;
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

    // Crear los arcos basados en los datos de prueba
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

        document.getElementById('circular-grafics-description').innerHTML="Promedio de horas con los mayores indices de consumo"

}


// Función para mostrar el gráfico de barras
function showBarChart(data) {
    // Configuración del tamaño del lienzo
    var margin = { top: 20, right: 20, bottom: 30, left: 60 };
    var width = 300;
    var height = 300;

    // Días de la semana correspondientes a cada valor de dayOfWeek
    var daysOfWeek = ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'];

    // Configuración de la escala x para los días de la semana
    var xScale = d3.scaleBand()
        .domain(data.map(d => daysOfWeek[d.dayOfWeek]))
        .range([0, width])
        .padding(0.1);

    // Configuración de la escala y para los valores de datos
    var yScale = d3.scaleLinear()
        .domain([0, d3.max(data, d => d.average)])
        .range([height, 0]);

    // Seleccionar el elemento con el id "bar-chart"
    var container = d3.select("#bar-grafics");

    var svg = container.append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
        .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

    // Crear las barras basadas en los datos
    svg.selectAll("rect")
        .data(data)
        .enter().append("rect")
        .attr("x", function(d) { return xScale(daysOfWeek[d.dayOfWeek]); })
        .attr("y", function(d) { return yScale(d.average); })
        .attr("width", xScale.bandwidth())
        .attr("height", function(d) { return height - yScale(d.average); })
        .attr("fill", "steelblue");

    // Agregar etiquetas de texto para los días de la semana en el eje x
    svg.selectAll("text")
        .data(data)
        .enter().append("text")
        .attr("x", function(d) { return xScale(daysOfWeek[d.dayOfWeek]) + xScale.bandwidth() / 2; })
        .attr("y", height + 10)
        .style("text-anchor", "middle")
        .text(function(d) { return daysOfWeek[d.dayOfWeek]; });

    // Configuración de la escala y para los intervalos en el eje izquierdo
    var yAxisScale = d3.scaleLinear()
        .domain([0, d3.max(data, d => d.average)])
        .range([height, 0]);

    // Crear eje y a la izquierda
    var yAxis = d3.axisLeft(yAxisScale);

    // Agregar el eje y a la izquierda
    svg.append("g")
        .attr("class", "y-axis")
        .call(yAxis);

    // Agregar etiqueta de descripción
    document.getElementById('bar-grafics-description').innerHTML = "Promedio de picos de memoria según los días de la semana (gráfico de barras)";
}




//-----------------------------------------------------------------------------------------------------------------------//


// Llamar a la función con datos de ejemplo
