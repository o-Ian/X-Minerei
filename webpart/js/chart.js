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
      }
    }

    let chart = new
      Chart(document.getElementById('chart'), options);
});


  

