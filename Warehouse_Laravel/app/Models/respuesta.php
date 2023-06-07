<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Respuesta extends Model
{
    use HasFactory;

    protected $table = 'respuestas';
    
    protected $fillable = ['form_data_id', 'encuesta_id', 'tipo_encuesta_id', 'fecha', 'metadatos', 'created_at'];

    protected $dates = [
        'fecha',
    ];

}

?>