d3.csv('http://127.0.0.1:5500/Mineration_DATA.ETH/AllData.csv')
  .then(function (loadedData){
  
    let data = [];
    let labels = [];
    
    for (let i = 0; i < loadedData.length; i++){
      

      let indicators = (loadedData[i].Indicador*100);
      let dates = (loadedData[i].Date);
      data.push(indicators);
      labels.push(dates);
      
    };
    console.log(data);
    console.log(labels);
    let options = {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          data: data,
          label: 'Custo energia/faturamento',
          fill: false,
          backgroundColor: 'rgb(255, 99, 132)',
          borderColor: 'rgb(255, 99, 132)',
          pointRadius: 0,
          pointHoverRadius: 0          
        }]
      },
      options: {
        plugins: {
            legend: {
                display: false,
                text: 'Custom Chart Title'
          },
          title: {
            display: true,
            text: 'Gasto da energia/Faturamento',
            color: '#fff',
            padding: {
              top: 11,
              bottom: 11
          },
            font: {
              weight: 'normal',
              size: 13,
              family: "'Montserrat', sans-serif"
            },
            
          }
        },
      scales: {
        y: {
          max: 100
        }
      },
      
    }
  }

    let chart = new
      Chart(document.getElementById('chart'), options);
});


  

