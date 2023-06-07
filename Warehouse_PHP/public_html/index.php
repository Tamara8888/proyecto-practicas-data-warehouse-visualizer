<?php

require_once '../vendor/autoload.php';
use Tamara\Warehouse\Conexion;

// Uso de la clase
$conectar = new Conexion("127.0.0.1", "practicas", "abc123.", "admin_warehouse");

// Obtener la conexión
$conexion = $conectar->getConnection();

// Obtener el número total de registros en la tabla
$conteoComando = "SELECT COUNT(*) AS total FROM respuestas";
$conteoResult = $conexion->query($conteoComando);
$totalRegistros = $conteoResult->fetch_assoc()['total'];

// Parámetros de paginación
$registrosPorPagina = 50; // Cantidad de registros por página
$totalPaginas = ceil($totalRegistros / $registrosPorPagina); // Total de páginas

// Obtener la página actual
$paginaActual = isset($_GET['page']) ? intval($_GET['page']) : 1;
$paginaActual = max(1, min($totalPaginas, $paginaActual)); // Asegurarse de que la página esté dentro de los límites

// Calcular el desplazamiento (offset) en la consulta
$offset = ($paginaActual - 1) * $registrosPorPagina;

// Consulta a la tabla de MySQL con limit y offset
$comando = "SELECT form_data_id, encuesta_id, tipo_encuesta_id, fecha, metadatos, created_at FROM respuestas ORDER BY fecha DESC LIMIT $registrosPorPagina OFFSET $offset";

$result = $conexion->query($comando);

$conexion->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>data-warehouse-visualizer</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
</head>
<body>
    <table id="tablaRespuestas">
        <thead>
            <tr>
                <th>form_data_id</th>
                <th>encuesta_id</th>
                <th>tipo_encuesta_id</th>
                <th>fecha</th>
                <th>metadatos</th>
                <th>created_at</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) 
        {
            // Recorrer los resultados y mostrarlos
            while ($row = $result->fetch_assoc()) 
            {
                echo "<tr>";
                echo "<td>" . $row['form_data_id'] . "</td>";
                echo "<td>" . $row['encuesta_id'] . "</td>";
                echo "<td>" . $row['tipo_encuesta_id'] . "</td>";
                echo "<td>" . $row['fecha'] . "</td>";
                echo "<td>";
                echo "<form method='post' action='json.php'>";
                echo "<input type='hidden' name='form_data_id' value='" . $row['form_data_id'] . "'>";
                echo "<input type='hidden' name='json' value='" . urlencode(json_encode($row)) . "'>";
                echo "<button type='submit'>Ver más</button>";
                echo "</form>";
                echo "</td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "</tr>";
            }
        } 
        else 
        {
            echo "<tr><td colspan='6'>No se encontraron resultados.</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php
        // Configuración de la paginación segmentada
        $bloquesPorPagina = 10; // Cantidad de bloques por página
        $bloqueActual = ceil($paginaActual / $bloquesPorPagina);
        $primerBloque = ($bloqueActual - 1) * $bloquesPorPagina + 1;
        $ultimoBloque = min($primerBloque + $bloquesPorPagina - 1, $totalPaginas);

        // Generar enlaces de paginación
        if ($primerBloque > 1) 
        {
            echo "<a href='?page=1'>&laquo;</a> ";
        }
        for ($i = $primerBloque; $i <= $ultimoBloque; $i++) 
        {
            $activeClass = ($i === $paginaActual) ? 'active' : '';
            echo "<a href='?page=$i' class='$activeClass'>$i</a> ";
        }
        if ($ultimoBloque < $totalPaginas) 
        {
            echo "<a href='?page=$totalPaginas'>&raquo;</a> ";
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() 
        {
        var tabla = $('#tablaRespuestas').DataTable();

        // Filtrar por encuesta_id al ingresar texto en el input
        $('#tablaRespuestas_filter input').on('keyup', function() 
        {
            tabla.columns(1).search(this.value).draw();
        });

        // Mostrar metadatos al hacer clic en el botón
        $('#tablaRespuestas').on('click', '.ver-metadatos', function() 
        {
            var metadatos = $(this).data('metadatos');
            alert('Metadatos:\n' + metadatos);
        });
    });
    </script>
</body>
</html>