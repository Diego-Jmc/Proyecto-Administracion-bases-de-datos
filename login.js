const openMonitorBtn = document.getElementById('open-monitor-btn')



openMonitorBtn.addEventListener('click',()=>{

    const server = document.getElementById('server-select').value
    
    window.location = `http://localhost/monitor_memoria/monitor.php?host=${server}`



})