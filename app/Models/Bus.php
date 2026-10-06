<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bus extends Model
{
    use HasFactory;

    protected $table = 'buses';

    protected $fillable = [
        'placa',
        'numero_bus',
        'capacidad',
        'estado'
    ];

    public function lineas()
    {
        return $this->belongsToMany(
            Linea::class,
            'asignaciones_bus_linea'
        )->withPivot('fecha_inicio', 'fecha_fin', 'estado');
    }

    public function parqueo()
    {
        return $this->hasOne(Parqueo::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(AsignacionBusLinea::class);
    }

    public function asignacionesPiloto()
    {
        return $this->hasMany(AsignacionPiloto::class);
    }

    public function recorridos()
    {
        return $this->hasMany(Recorrido::class);
    }
}
