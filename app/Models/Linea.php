<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Linea extends Model
{
    use HasFactory;

    protected $table = 'lineas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'municipio_id'
    ];

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    public function estaciones()
    {
        return $this->belongsToMany(
            Estacion::class,
            'linea_estacion'
        )->withPivot('orden', 'distancia');
    }

    public function buses()
    {
        return $this->belongsToMany(
            Bus::class,
            'asignaciones_bus_linea'
        )->withPivot('fecha_inicio', 'fecha_fin', 'estado');
    }

    public function recorridos()
    {
        return $this->hasMany(Recorrido::class);
    }
}
