<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estacion extends Model
{
    use HasFactory;

    protected $table = 'estaciones';

    protected $fillable = [
        'nombre',
        'direccion',
        'municipio_id'
    ];

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    public function lineas()
    {
        return $this->belongsToMany(
            Linea::class,
            'linea_estacion'
        )->withPivot('orden', 'distancia');
    }

    public function accesos()
    {
        return $this->hasMany(Acceso::class);
    }

    public function visitas()
    {
        return $this->hasMany(VisitaEstacion::class);
    }

    public function alertas()
    {
        return $this->hasMany(Alerta::class);
    }
}
