<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'buses';

    // Clave primaria
    protected $primaryKey = 'id_bus';

    // Campos permitidos para registro y actualización
    protected $fillable = [
        'codigo',
        'capacidad_maxima',
        'estado'
    ];

    // Conversión de tipos de datos
    protected $casts = [
        'capacidad_maxima' => 'integer'
    ];
}
