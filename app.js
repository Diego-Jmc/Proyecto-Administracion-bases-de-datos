
const margin = { top: 20, right: 30, bottom: 50, left: 50 };
const width = 800 - margin.left - margin.right;
const height = 400 - margin.top - margin.bottom;
document.getElementById('alert').style.display = 'none'

function showAlert(){

    document.getElementById('alert').style.display = 'block'

       setTimeout(() => {
        document.getElementById('alert').style.display = 'none'

       }, 1000); 


}

function postCBLOG(size_mb, used_mb, free_mb, process_id, time) {
    const url = 'http://localhost/monitor_memoria/services/cblog';
  
    // Create a JSON object with the data
    const data = {
      size_mb: size_mb,
      used_mb: used_mb,
      free_mb: free_mb,
      process_id: process_id,
      time: time
    };

    console.log(time)
  
    const fetchOptions = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    };
  
 
    fetch(url, fetchOptions)
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        console.log('Data sent successfully:', data);
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }
  


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

function drawHWM() {
    svg.append("line")
      .attr("class", "hwm-line")
      .attr("x1", 0)
      .attr("x2", width)
      .attr("y1", yScale(85))
      .attr("y2", yScale(85))
      .attr("stroke", "red")
      .attr("stroke-width", 2);
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





drawHWM();

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
      return Math.floor(Math.random() * (95 - 50 + 1)) + 50; 
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

  console.log(bufferCacheCurrentState)

        const now = new Date();

        porcentage = generateRandomData()

        const newDataPoint = {
        time: now,
        percentage:porcentage

        };

    
        if(porcentage > 85){
            postCBLOG(bufferCacheCurrentState.bufferCacheTotalMB,bufferCacheCurrentState.usedMemoryMB,bufferCacheCurrentState.freeMemoryMB,bufferCacheCurrentState,0,new Date());
            showAlert();
        }

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
