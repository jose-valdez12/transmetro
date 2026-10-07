<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{
    use HasFactory;

    protected $table = 'lineas';

    protected $primaryKey = 'id_linea';

    protected $fillable = [
        'nombre',
        'distancia_total',
        'id_municipio',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean',
        'distancia_total' => 'decimal:2',
    ];

    public function municipio()
    {
        return $this->belongsTo(
            Municipio::class,
            'id_municipio',
            'id_municipio'
        );
    }

    public function estaciones()
    {
        return $this->belongsToMany(
            Estacion::class,
            'linea_estacion',
            'id_linea',
            'id_estacion'
        )->withPivot('orden', 'distancia_anterior');
    }

    public function buses()
    {
        return $this->belongsToMany(
            Bus::class,
            'asignaciones_bus_linea',
            'id_linea',
            'id_bus'
        )->withPivot('fecha_inicio', 'fecha_fin', 'estado');
    }

    public function recorridos()
    {
        return $this->hasMany(
            Recorrido::class,
            'id_linea',
            'id_linea'
        );
    }
}
