<?php
use Tamara\Warehouse\Comment;
use Tamara\Warehouse\Data;
use Tamara\Warehouse\Response;
use Tamara\Warehouse\Root;

$jsonString = $_POST['json'];
$datosJson = json_decode(urldecode($jsonString));

$stringMetadatos = $datosJson->metadatos;
$metadata = json_decode($stringMetadatos);

$data = $metadata->data;

// Recorriendo la clase Data
echo '<table>';
foreach ($data as $key => $value) 
{
    if ($key !== 'comments' && $key !== 'responses' && !empty($value)) 
    {
        echo "<tr>";
        echo "<td>" . $key . "</td>";
        echo "<td>" . $value . "</td>";
        echo "</tr>";
    } 
    elseif ($key === 'comments') 
    {
        foreach ($data->comments as $comment) 
        {
            echo "<tr>";
            echo "<td>comments." . $comment->id . "</td>";
            echo "<td>" . $comment->texto . "</td>";
            echo "<td>" . $comment->valoracion . "</td>";
            echo "</tr>";
        }
    } 
    elseif ($key === 'responses') 
    {
        foreach ($data->responses as $response) 
        {
            echo "<tr>";
            echo "<td>responses." . $response->id . "</td>";
            echo "<td>" . $response->pregunta . "</td>";
            echo "<td>" . $response->respuesta . "</td>";
            echo "</tr>";
        }
    }
}
echo '</table>';

echo '<br>';
?>
