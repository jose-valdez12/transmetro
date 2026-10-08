<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Municipio;
use App\Models\Linea;
use App\Models\Acceso;
use App\Models\VisitaEstacion;
use App\Models\Alerta;

class Estacion extends Model
{
      use HasFactory;

    protected $table = 'estaciones';

    protected $primaryKey = 'id_estacion';

    protected $fillable = [
        'nombre',
        'direccion',
        'id_municipio',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];


   public function municipio()
    {
        return $this->belongsTo(
            Municipio::class,
            'id_municipio',
            'id_municipio'
        );
    }

    public function lineas()
    {
        return $this->belongsToMany(
            Linea::class,
            'linea_estacion',
            'id_estacion',
            'id_linea'
        )->withPivot('orden', 'distancia_anterior');
    }

    public function accesos()
    {
        return $this->hasMany(
            Acceso::class,
            'id_estacion',
            'id_estacion'
        );
    }
     public function visitas()
    {
        return $this->hasMany(
            VisitaEstacion::class,
            'id_estacion',
            'id_estacion'
        );
    }

     public function alertas()
    {
        return $this->hasMany(
            Alerta::class,
            'id_estacion',
            'id_estacion'
        );
    }
}
