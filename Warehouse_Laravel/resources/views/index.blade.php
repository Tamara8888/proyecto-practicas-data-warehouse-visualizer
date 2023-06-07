<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Respuestas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Menú de navegación -->
    <nav class="navbar navbar-expand">
        <div class="navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" style='color: #2B2B2B' href="/"><i class="fas fa-home"></i> Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style='color: #2B2B2B' href="index"><i class="fas fa-poll"></i> Encuestas</a>
                </li>
            </ul>
        </div>
    </nav>
    <p></p>
    <!-- Botón y cuadro de búsqueda -->
    <div class="col">
        <form action="{{ route('index') }}" method="GET">
            <div class="input-group">
                <input type="text" name="buscar" class="form-control custom-search-input" placeholder="Buscar por ID">
                <input type="date" id="fecha" name="fecha" min="2014-01-01" max="2017-12-31">
                <button class="btn btn-primary btn-buscar" type="submit">Buscar</button>
            </div>
        </form>
    </div>
    <p></p>
    <!-- Cargar respuestas -->
    <div class="row justify-content-start">
        <div class="col-md-4 text-center">
            <h4>form_data_id</h4>
            <p></p>
            @foreach ($respuestas as $respuesta)
                <ul>{{ $respuesta->form_data_id }}</ul>
            @endforeach
        </div>
        <div class="col text-center">
            <h4>encuesta_id</h4>
            <p></p>
            @foreach ($respuestas as $respuesta)
                <ul>{{ $respuesta->encuesta_id }}</ul>
            @endforeach
        </div>
        <div class="col text-center">
            <h4>tipo_encuesta_id</h4>
            <p></p>
            @foreach ($respuestas as $respuesta)
                <ul>{{ $respuesta->tipo_encuesta_id }}</ul>
            @endforeach
        </div>
        <div class="col-md-2 text-center">
            <h4>fecha</h4>
            <p></p>
            @foreach ($respuestas as $respuesta)
                <ul>{{ $respuesta->fecha }}</ul>
            @endforeach
        </div>
        <div class="col text-center">
            <h4>metadatos</h4>
            <p></p>
            @foreach ($respuestas as $respuesta)
                <div class="col-md d-flex flex-column">
                    <div class="row">
                        <div class="col">
                            <ul id="metadatos-{{ $respuesta->id }}" class="metadatos-list">{{ $respuesta->metadatos }}</ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <form method="POST" action="{{ route('mostrar_metadatos') }}">
                                @csrf
                                <input type="hidden" name="metadatos-{{ $respuesta->id }}" value="{{$respuesta->metadatos}}">
                                <input type="hidden" name="json" value="{{urlencode(json_encode($respuesta))}}">
                                <button type="submit" class="btn btn-outline-primary btn-ver-mas">Ver más</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-2 text-center">
            <h4>created_at</h4>
            <p></p>
            @foreach ($respuestas as $respuesta)
                <ul>{{ $respuesta->created_at }}</ul>
            @endforeach
        </div>
    </div>
    <!-- Paginación -->
    <nav aria-label="Paginación de la consulta">
        <div class="pagination-container">
            <ul class="pagination justify-content-center">
                @if ($respuestas->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Anterior</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $respuestas->previousPageUrl() }}" aria-label="Anterior">
                            <span aria-hidden="true">Anterior</span>
                        </a>
                    </li>
                @endif
                @if ($respuestas->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $respuestas->nextPageUrl() }}" aria-label="Siguiente">
                            <span aria-hidden="true">Siguiente</span>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">Siguiente</span>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</body>
</html>
