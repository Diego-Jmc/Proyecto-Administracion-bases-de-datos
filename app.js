const questions = document.querySelectorAll('.question-tr').length
const evaluateResultsBtn = document.getElementById('evaluate-results-btn')
const ctx = document.getElementById('myChart').getContext('2d')



const porcentajes = [0, 0, 0];
const etiquetas = ['Sí', 'No', 'Na'];

const myChart = new Chart(ctx, {

    type: 'bar',
    data: {
        labels: etiquetas,
        datasets: [{
            data: porcentajes,
            backgroundColor: ['#539165', '#C70039', '#FBD85D'],
          
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
})

function updateResults(yes, no, na) {
    let finalResult = ''

    if (yes === 100) {
        finalResult = 'Cumplimiento total'
    } else if (yes >= 80 && yes < 100) {
        finalResult = 'Cumplimiento satisfactorio'
    } else if (yes >= 60 && yes < 80) {
        finalResult = 'Cumplimiento parcial'
    } else {
        finalResult = 'Cumplimiento deficiente'
    }

    document.getElementById('results').innerHTML = `
        <h3>Resultados</h3>
        <p>Si: ${yes.toFixed(2)} %</p>
        <p>No: ${no.toFixed(2)}%</p>
        <p>Na: ${na.toFixed(2)}%</p>
        <h3>${finalResult}</h3>
    `;
}


function update(yes, no, na) {
    const newPorcentajes = [yes, no, na];

    myChart.data.datasets[0].data = newPorcentajes
    myChart.update()
    updateResults(yes, no, na)

}


function getPorcentage(answers,term){

    let part = answers[term] 

    return ( part / questions) * 100

}




evaluateResultsBtn.addEventListener('click', () => {

    let blankSpace = false

    const answers = {
        "si": 0,
        "no": 0,
        "na": 0
    }

    for (let i = 0; i < questions; i++) {

        const selectedAnswer = document.querySelector(`input[name="answer_${i + 1}"]:checked`)
        
    
        if (selectedAnswer) {

            const answerValue = selectedAnswer.value

            switch (answerValue) {
                case "si":
                    answers["si"]++
                    break
                case "no":
                    answers["no"]++
                    break
                case "na":
                    answers["na"]++
                    break
                case "":
                    blankSpace = true
                default:
                    break
            }
        }else{
            blankSpace = true
            break
        }


    }

    
    if(!blankSpace){    


        let yes = getPorcentage(answers,'si')
        let no = getPorcentage(answers,'no')
        let na = getPorcentage(answers,'na')



        update(yes,no,na)

    }else{

        

    }


});
