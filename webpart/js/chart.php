<script>
let data = <?=$_SESSION['EnergyCost_Revenue'];?>;

let labels = <?=$_SESSION['Date_UTC'];?>;

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
            
        }
      },
      
    }
  }

    let chart = new
      Chart(document.getElementById('chart'), options);

    /*$('#form_adiciona_pgu').submit(function(e){
      $.post('atualizacao-chart.php', function(retorna){

    console.log('TÁ ENTRANDO12313123')
    obj_chart = JSON.parse(retorna);

    chart.data.labels = retorna.Date_UTC;
    chart.data.datasets[0].data = retorna.EnergyCost_Revenue;
    chart.update();

    console.log( retorna.Date_UTC);

    console.log(retorna.EnergyCost_Revenue)

    })
  })*/
</script>