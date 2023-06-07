<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Warehouse</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Menú de navegación -->
  <nav class="navbar navbar-expand">
    <div class="navbar-collapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="/"><i class="fas fa-home"></i> Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index"><i class="fas fa-poll"></i> Encuestas</a>
        </li>
      </ul>
    </div>
  </nav>
  
  <!-- Resumen de la cantidad de encuestas -->
  <h2 class="text-center">Resumen</h2>
  <div class="container mt-5">
    <section id="resumen">
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Fecha con más Nº de encuestas</h5>
              <h6 class="card-subtitle mb-2 text-muted">Fecha</h6>
              <p class="card-text"><span id="encuestasMes"></span></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Año con más Nº de encuestas</h5>
              <h6 class="card-subtitle mb-2 text-muted">Año</h6>
              <p class="card-text"><span id="encuestasUltimoAnho"></span></p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Total Encuestas</h5>
              <h6 class="card-subtitle mb-2 text-muted">Cantidad</h6>
              <p class="card-text"><span id="totalEncuestas"></span></p>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Gráfico encuestas por fecha -->
    <section id="charts" class="mt-5">
      <div class="row">
        <div class="col-md-6">
          <h2 class="text-center">Encuestas por años</h2>
          <canvas id="encuestasAnho"></canvas>
        </div>
        <div class="col-md-6">
          <h2 class="text-center">Encuestas por meses</h2>
          <canvas id="graficoMeses"></canvas>
        </div>
      </div>
    </section>
  </div>
  
  <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <script>
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
          $('#encuestasUltimoAnho').text(data);
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

    // Actualiza los datos del dashboard al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
      // Obtén los datos de encuestas por año del controlador
      var encuestasPorAnho = {!! json_encode($encuestasPorAnho) !!};

      // Crea un array para almacenar las etiquetas y los datos de encuestas por año
      var labelsAnho = [];
      var datosAnho = [];

      // Recorre los resultados y extrae las etiquetas y los datos
      encuestasPorAnho.forEach(function(encuesta) {
        labelsAnho.push(encuesta.anho);
        datosAnho.push(encuesta.total);
      });

      // Actualiza los datos del gráfico de encuestas por año
      var encuestasAnho = new Chart(document.getElementById('encuestasAnho').getContext('2d'), {
        type: 'bar',
        data: {
          labels: labelsAnho,
          datasets: [{
            label: 'Encuestas',
            data: datosAnho,
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

      // Obtén los datos de encuestas por mes del controlador
      var encuestasPorMes = {!! json_encode($encuestasPorMes) !!};

      // Crea un array para almacenar las etiquetas y los datos de encuestas por mes
      var labelsMes = [];
      var datosMes = [];

      // Recorre los resultados y extrae las etiquetas y los datos
      encuestasPorMes.forEach(function(encuesta) {
        labelsMes.push(encuesta.mes);
        datosMes.push(encuesta.total);
      });

      // Actualiza los datos del gráfico de encuestas por mes
      var graficoMeses = new Chart(document.getElementById('graficoMeses').getContext('2d'), {
        type: 'pie',
        data: {
          labels: labelsMes,
          datasets: [{
            label: 'Encuestas',
            data: datosMes,
            backgroundColor: ['#fbf8cc','#fde4cf','#ffcfd2','#f1c0e8','#cfbaf0','#a3c4f3','#90dbf4','#8eecf5','#98f5e1','#b9fbc0','#d9f9cc','#e7fde4'],
            borderColor: ['#fbf8cc','#fde4cf','#ffcfd2','#f1c0e8','#cfbaf0','#a3c4f3','#90dbf4','#8eecf5','#98f5e1','#b9fbc0','#d9f9cc','#e7fde4'],
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
    });
  </script>
</body>
</html>
