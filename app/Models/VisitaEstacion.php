<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitaEstacion extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'visitas_estacion';

    // Clave primaria
    protected $primaryKey = 'id_visita';

    // Campos permitidos
    protected $fillable = [
        'id_recorrido',
        'id_estacion',
        'fecha_hora_llegada',
        'fecha_hora_salida',
        'cantidad_pasajeros'
    ];

    // Conversión de tipos de datos
    protected $casts = [
        'fecha_hora_llegada' => 'datetime',
        'fecha_hora_salida' => 'datetime',
        'cantidad_pasajeros' => 'integer'
    ];

    // Relación con el recorrido
    public function recorrido()
    {
        return $this->belongsTo(
            Recorrido::class,
            'id_recorrido',
            'id_recorrido'
        );
    }

    // Relación con la estación
    public function estacion()
    {
        return $this->belongsTo(
            Estacion::class,
            'id_estacion',
            'id_estacion'
        );
    }
}
