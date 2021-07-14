const labels = [
  'January',
  'February',
  'March',
  'April',
  'May',
  'June',
];
const data = {
  labels: labels,
  datasets: [{
    label: 'Gasto da energia/Faturamento',
    backgroundColor: 'rgb(255, 99, 132)',
    borderColor: 'rgb(255, 99, 132)',
    data: [0, 10, 5, 2, 20, 30, 45],
  }]
};
const config = {
  type: 'line',
  data,
  options: {}
};  
        // === include 'setup' then 'config' above ===
      
        var myChart = new Chart(
          document.getElementById('myChart'),
          config
        );