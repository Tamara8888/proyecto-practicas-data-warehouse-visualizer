$(document).ready(function() {
    // Llama a las funciones del controlador y actualiza los elementos HTML correspondientes
    $.ajax({
      url: '/dashboard/encuestas-fecha',
      method: 'GET',
      success: function(data) {
        $('#encuestasMes').text(data);
      }
    });
  
    $.ajax({
      url: '/dashboard/encuestas-anho',
      method: 'GET',
      success: function(data) {
        $('#escuetasUltimoAnho').text(data);
      }
    });
  
    // Mostrar el spinner
    $('#totalEncuestas').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div>');
  
    $.ajax({
      url: '/dashboard/encuestas-total',
      method: 'GET',
      success: function(data) {
        $('#totalEncuestas').text(data);
      }
    });
  });
  
  document.addEventListener('DOMContentLoaded', function() {
    // Obtén los datos de encuestas por año del controlador
    var encuestasPorAnho = json_encode($encuestasPorAnho);
  
    // Crea un array para almacenar las etiquetas y los datos de encuestas por año
    var labels = [];
    var datos = [];
  
    // Recorre los resultados y extrae las etiquetas y los datos
    encuestasPorAnho.forEach(function(encuesta) {
      labels.push(encuesta.anho);
      datos.push(encuesta.total);
    });
  
    // Actualiza los datos del gráfico
    var encuestasAnho = new Chart(document.getElementById('encuestasAnho').getContext('2d'), {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Encuestas',
          data: datos,
          backgroundColor: '#B0E0E6',
          borderColor: '#B0E0E6',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  
    var encuestasPorMes = json_encode($encuestasPorMes);
  
    // Crea un array para almacenar las etiquetas y los datos de encuestas por mes
    var labelsMes = [];
    var datosMes = [];
  
    // Recorre los resultados y extrae las etiquetas y los datos
    encuestasPorMes.forEach(function(encuesta) {
      labelsMes.push(encuesta.mes);
      datosMes.push(encuesta.total);
    });
  
    // Actualiza los datos del gráfico de encuestas por mes
    var dataMes = {
      labels: labelsMes,
      datasets: [{
        data: datosMes,
        backgroundColor: [
          '#fbf8cc',
          '#fde4cf',
          '#ffcfd2',
          '#f1c0e8',
          '#cfbaf0',
          '#a3c4f3',
          '#90dbf4',
          '#8eecf5',
          '#98f5e1',
          '#b9fbc0',
          '#d9f9cc',
          '#e7fde4'
        ]
      }]
    };
  
    // Configura las opciones del gráfico de encuestas por mes
    var optionsMes = {
      responsive: true,
      maintainAspectRatio: false
    };
  
    // Crea el gráfico de encuestas por mes
    var encuestasMes = new Chart(document.getElementById('graficoMeses').getContext('2d'), {
      type: 'pie',
      data: dataMes,
      options: optionsMes
    });
  });
  