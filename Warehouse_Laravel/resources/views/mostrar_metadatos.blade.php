<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Respuestas de la encuesta</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body class="p-3 m-0 border-0 bd-example m-0 border-0" style="background-image: linear-gradient(0, #f8ffd5 0, #e8ffd9 8.33%, #d8ffdb 16.67%, #c8ffdc 25%, #b9ffdc 33.33%, #aaffda 41.67%, #9df2d5 50%, #92e3cf 58.33%, #8ad6ca 66.67%, #84cbc4 75%, #7fc1c0 83.33%, #7cb9bc 91.67%, #7bb3b9 100%);">
    <button type="button" class="btn-close" aria-label="Cerca" onclick="goBack()"></button>
    {!! $tableContent !!}

    <script>
    function goBack() 
    {
        window.history.back();
    }
    </script>
  </body>
</html>
