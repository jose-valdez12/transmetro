<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recorrido extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'recorridos';

    // Clave primaria
    protected $primaryKey = 'id_recorrido';

    // Campos permitidos
    protected $fillable = [
        'id_bus',
        'id_linea',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado'
    ];

    // Conversión de fechas
    protected $casts = [
        'fecha' => 'date'
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

    // Visitas realizadas a estaciones
    public function visitas()
    {
        return $this->hasMany(
            VisitaEstacion::class,
            'id_recorrido',
            'id_recorrido'
        );
    }

    // Alertas relacionadas con el recorrido
    public function alertas()
    {
        return $this->hasMany(
            Alerta::class,
            'id_recorrido',
            'id_recorrido'
        );
    }
}
