<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminWarehouseController;
use App\Http\Controllers;
use App\Providers;


// Rutas dashboard
Route::get('/', 'App\Http\Controllers\AdminWarehouseController@mostrarDashboard')->name('dashboard');

Route::get('/dashboard/encuestas-fecha', [AdminWarehouseController::class, 'mostrarFechaMayorEncuestas']);

Route::get('/dashboard/encuestas-anho', [AdminWarehouseController::class, 'mostrarEncuestasAnho']);

Route::get('/dashboard/encuestas-total', [AdminWarehouseController::class, 'mostrarEncuestasTotal']);

Route::get('/dashboard/encuestas-por-mes', [AdminWarehouseController::class, 'mostrarEncuestasPorMes']);

// Rutas index
Route::get('/index', 'App\Http\Controllers\AdminWarehouseController@cargarRespuestas')->name('index');

Route::post('/mostrar_metadatos', [AdminWarehouseController::class,'procesarDatosJson'])->name('mostrar_metadatos');



