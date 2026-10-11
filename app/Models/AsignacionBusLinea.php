<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Bus;
use App\Models\Linea;

class AsignacionBusLinea extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'asignaciones_bus_linea';

    // Clave primaria
    protected $primaryKey = 'id_asignacion';

    // Campos permitidos
    protected $fillable = [
        'id_bus',
        'id_linea',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    // Conversión de tipos de datos
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'estado' => 'boolean'
    ];

    // Relación con el bus
    public function bus()
    {
        return $this->belongsTo(
            Bus::class,
            'id_bus',
            'id_bus'
        );
    }

    // Relación con la línea
    public function linea()
    {
        return $this->belongsTo(
            Linea::class,
            'id_linea',
            'id_linea'
        );
    }
}
