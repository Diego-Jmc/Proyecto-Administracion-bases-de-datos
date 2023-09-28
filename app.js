const container = document.getElementById('main-container')


const api_url = 'http://localhost/monitor_tablespaces'

async function getTableSpacesInfo(){

    const data = await  fetch(`${api_url}/services/database.php`)
    const json = await data.json()
    return json

}

var datos = [];
var etiquetas = []; 

async function loadContent(){

    const tablespaceData = await getTableSpacesInfo()

   tablespaceData.forEach(element => {

    datos.push(element.pctFree)
    etiquetas.push(element.tablespace); 

   });

   
var ancho = 800;
var alto = 400;
var margen = { superior: 20, derecho: 30, inferior: 30, izquierdo: 40 };

var svg = d3.select("#grafico")
    .append("svg")
    .attr("width", ancho)
    .attr("height", alto);

var g = svg.append("g")
    .attr("transform", "translate(" + margen.izquierdo + "," + margen.superior + ")");

var x = d3.scaleLinear()
    .domain([0, 100]) 
    .range([0, ancho - margen.izquierdo - margen.derecho]);

var y = d3.scaleBand()
    .domain(d3.range(datos.length)) 
    .range([0, alto - margen.superior - margen.inferior])
    .padding(0.1);

g.selectAll("rect")
    .data(datos)
    .enter().append("rect")
    .attr("x", 0)
    .attr("y", function (d, i) { return y(i); })
    .attr("width", function (d) { return x(d); })
    .attr("height", y.bandwidth())
    .style("fill", "steelblue");

g.append("line")
    .attr("x1", x(80))
    .attr("y1", 0)
    .attr("x2", x(80))
    .attr("y2", alto - margen.superior - margen.inferior)
    .style("stroke", "red")
    .style("stroke-width", 2);

g.append("g")
    .attr("transform", "translate(0," + (alto - margen.superior - margen.inferior) + ")")
    .call(d3.axisBottom(x)
        .tickValues(d3.range(0, 101, 10))
    );

g.selectAll(".etiqueta")
    .data(etiquetas)
    .enter().append("text")
    .attr("class", "etiqueta")
    .attr("x", 5) 
    .attr("y", function (d, i) { return y(i) + y.bandwidth() / 2; })
    .attr("dy", "0.35em")
    .style("font-size", "12px")
    .style("fill", "black")
    .text(function (d) { return d; });

    

g.append("g")
    .call(d3.axisLeft(y));

    
}

loadContent()




