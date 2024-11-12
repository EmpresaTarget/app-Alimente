const ctx2 = document.getElementById('doughnut').getContext('2d');

new Chart(ctx2, {
  type: 'doughnut',
  data: {
    labels: ['Blue', 'purple'],
    datasets: [{
      label: '# of Votes',
      data: [12, 19],
      borderWidth: 1,
      backgroundColor: [
        'rgb(39, 122, 185)',
        'rgb(53, 104, 167)',
        
      ],
      borderColor: [
        'rgb(240, 240, 240)',
        'rgb(240, 240, 240)',
      ]
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    cutout: '30%', 
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Acessos (passados 1 mês)'
      }
    }
  }
});
