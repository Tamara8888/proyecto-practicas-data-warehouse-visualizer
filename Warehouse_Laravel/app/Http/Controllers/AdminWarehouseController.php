<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Respuesta;
use App\Models\Encuesta;
use App\Models;
use App\Models\Comment;
use App\Models\Data;
use App\Models\Response;
use App\Models\Root;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;



class AdminWarehouseController extends Controller
{  
    // Funciones dashboard

    public function mostrarDashboard(Request $request)
    {
       // return view('dashboard');


       $encuestasPorAnho = Respuesta::selectRaw("DATE_FORMAT(fecha, '%Y') AS anho, COUNT(*) AS total")
            ->groupByRaw("DATE_FORMAT(fecha, '%Y')")
            ->orderByRaw("DATE_FORMAT(fecha, '%Y')")
            ->havingRaw("anho != '0000'")
            ->get();
        
        $encuestasPorMes = Respuesta::selectRaw("DATE_FORMAT(fecha, '%M') AS mes, COUNT(*) AS total")
            ->groupByRaw("DATE_FORMAT(fecha, '%M')")
            ->orderByRaw("DATE_FORMAT(fecha, '%M')")
            ->havingRaw("mes != 'null'")
            ->get();
    
        return view('dashboard', compact('encuestasPorAnho','encuestasPorMes'));
    }

    public function mostrarFechaMayorEncuestas()
    {
        $result = Respuesta::select('fecha')
            ->groupBy('fecha')
            ->orderByRaw('COUNT(*) DESC')
            ->first();
    
        if ($result) {
            $fecha = $result->fecha;
            $fechaFormateada = date('d/m/Y', strtotime($fecha));
            return $fechaFormateada;
        }
        
        return null;
    }
    
    public function mostrarEncuestasAnho()
    {
        $encuestasPorAnho = Respuesta::selectRaw('YEAR(fecha) as anho, COUNT(*) as total')
            ->groupBy('anho')
            ->orderByDesc('total')
            ->first();
    
        if ($encuestasPorAnho) {
            $anho = $encuestasPorAnho->anho;
            return date('Y', strtotime("$anho-01-01"));
        }
    
        return null;
    }
    

    public function mostrarEncuestasTotal()
    {
        $count = Respuesta::count();

        return $count;
    }

    // Funciones index
    public function cargarRespuestas(Request $request)
    {
        $searchValue = $request->input('buscar');
        $fecha = $request->input('fecha');

        $query = Respuesta::query();

        if ($searchValue) {
            $exists = Respuesta::where('encuesta_id', $searchValue)->exists();

            if (!$exists) {
                return redirect()->route('index')->with('error', 'El valor buscado no existe en la base de datos.');
            }

            $query->where('encuesta_id', $searchValue);
        }

        if ($fecha) {
            $fechaCarbon = Carbon::parse($fecha);
            $query->whereDate('fecha', $fechaCarbon->startOfDay()->format('Y-m-d H:i:s'));
        }

        $respuestas = $query->orderBy('fecha', 'desc')->simplePaginate(20);

        return view('index', compact('respuestas'));
    }

    // Funciones mostrar_metadatos
    public function procesarDatosJson(Request $request)
    {
        $jsonString = $request->input('json','');
        $datosJson = json_decode(urldecode($jsonString));
        
        $stringMetadatos = $datosJson->metadatos;
        $metadata = json_decode($stringMetadatos);

        $data = $metadata->data;

        $tableContent = '<table style="border-collapse: collapse; width: 100%;">';

        foreach ($data as $key => $value) {
            if ($key !== 'comments' && $key !== 'responses' && !empty($value)) 
            {
                $tableContent .= "<tr>";
                $tableContent .= "<th style='border: 1px solid #ddd; padding: 8px; font-weight: bold; font-size: 14px;'> " . $key . "</th>";
                $tableContent .= "<td style='border: 1px solid #ddd; padding: 8px;'> " . $value . "</td>";
                $tableContent .= "</tr>";
            } 
            elseif ($key === 'comments') 
            {
                foreach ($data->comments as $comment) {
                    $tableContent .= "<tr>";
                    $tableContent .= "<th style='border: 1px solid #ddd; padding: 8px; font-weight: bold; font-size: 14px;'>comments." . $comment->id . "</th>";
                    $tableContent .= "<td style='border: 1px solid #ddd; padding: 8px;'> " . $comment->texto . "</td>";
                    $tableContent .= "<td style='border: 1px solid #ddd; padding: 8px;'> " . $comment->valoracion . "</td>";
                    $tableContent .= "</tr>";
                }
            } 
            elseif ($key === 'responses') 
            {
                foreach ($data->responses as $response) 
                {
                    $tableContent .= "<tr>";
                    $tableContent .= "<th style='border: 1px solid #ddd; padding: 8px; font-weight: bold; font-size: 14px;'>responses." . $response->id . "</th>";
                    $tableContent .= "<td style='border: 1px solid #ddd; padding: 8px;'> " . $response->pregunta . "</td>";
                    $tableContent .= "<td style='border: 1px solid #ddd; padding: 8px;'> " . $response->respuesta . "</td>";
                    $tableContent .= "</tr>";
                }
            }
        }

        $tableContent .= '</table>';

        return view('mostrar_metadatos')->with('tableContent', $tableContent);
    }
 
  

    
}