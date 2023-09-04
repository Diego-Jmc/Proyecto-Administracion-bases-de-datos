
const margin = { top: 20, right: 30, bottom: 50, left: 50 };
const width = 800 - margin.left - margin.right;
const height = 400 - margin.top - margin.bottom;


async function fetchData() {
  const url = 'http://localhost/monitor_memoria/services/memory.php';

  try {
    const response = await fetch(url);

    if (!response.ok) {
      throw new Error('Error en la solicitud: ' + response.status);
    }

    const data = await response.json();

    return data;

  } catch (error) {
    console.error('Error:', error);
    throw error; 
  }
}



const svg = d3.select("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform", `translate(${margin.left},${margin.top})`);

const xScale = d3.scaleTime()
    .domain([new Date().setHours(13, 0, 0, 0), new Date().setHours(13, 59, 59, 999)])
    .range([0, width]);

const yScale = d3.scaleLinear()
    .domain([0, 100])
    .range([height, 0]);

const line = d3.line()
    .x(d => xScale(d.time))
    .y(d => yScale(d.percentage));

const path = svg.append("path")
    .datum([])
    .attr("fill", "none")
    .attr("stroke", "blue")
    .attr("stroke-width", 2);

const xAxis = svg.append("g")
    .attr("class", "x-axis")
    .attr("transform", `translate(0, ${height})`);

const yAxis = svg.append("g")
    .attr("class", "y-axis");

function generateRandomData() {
      return Math.floor(Math.random() * (90 - 50 + 1)) + 50; 
}
  
function formatXAxisLabel(time) {
    const hour = d3.timeFormat("%I:%M %p")(time);
    return hour;
}

async function  updateChart(){

  const bufferCacheCurrentState = await fetchData()
  const bufferCacheTotalMB = parseFloat(bufferCacheCurrentState.bufferCacheTotalMB);
  const usedMemoryMB = parseFloat(bufferCacheCurrentState.usedMemoryMB);

  const memoryUsagePercentage = (usedMemoryMB / bufferCacheTotalMB) * 100; 


  const now = new Date();



        const newDataPoint = {
        time: now,
        percentage: generateRandomData()
    };

    

    /*
    const newDataPoint = {
        time: now,
        percentage: memoryUsagePercentage,
    };

    */
    const data = path.datum();
    data.push(newDataPoint);

    xScale.domain([now - 30 * 1000, now]); // Mostrar los últimos 30 segundos

    xAxis.call(d3.axisBottom(xScale).tickFormat(formatXAxisLabel));
    yAxis.call(d3.axisLeft(yScale));

    path.attr("d", line)
        .attr("transform", null)
        .transition()
        .duration(5000)
        .ease(d3.easeLinear)
        .attr("transform", "translate(" + xScale(now - 30 * 1000) + ")"); 

    if (data.length > 180) { 
        data.shift();
    }

    setTimeout(updateChart, 5000); 
}


updateChart();
