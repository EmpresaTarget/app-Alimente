const ctx = document.getElementById('lineChart');

new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['Jan', 'fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    datasets: [{
      label: 'Indices de Doações',
      data: [0,0,0,0,0,0,0,0,1,3,10,5],
      backgroundColor: [
        'rgba(45, 91, 151, 1)'
      ],
      
      borderWidth: 1
    }]
  },
  options: {
    responsive: true
  },
});

