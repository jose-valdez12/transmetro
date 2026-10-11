<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estacion extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'estaciones';

    // Clave primaria
    protected $primaryKey = 'id_estacion';

    // Campos permitidos
    protected $fillable = [
        'nombre',
        'direccion',
        'id_municipio',
        'estado',
        'capacidad_maxima',
        'pasajeros_actuales'
    ];

    // Tipos de datos
    protected $casts = [
        'estado' => 'boolean',
        'capacidad_maxima' => 'integer',
        'pasajeros_actuales' => 'integer'
    ];

    // Relación con municipio
    public function municipio()
    {
        return $this->belongsTo(
            Municipio::class,
            'id_municipio',
            'id_municipio'
        );
    }

    // Relación con líneas
    public function lineas()
    {
        return $this->belongsToMany(
            Linea::class,
            'linea_estacion',
            'id_estacion',
            'id_linea'
        )->withPivot(
            'orden',
            'distancia_anterior'
        );
    }

    // Relación con visitas
    public function visitas()
    {
        return $this->hasMany(
            VisitaEstacion::class,
            'id_estacion',
            'id_estacion'
        );
    }

    // Relación con alertas
    public function alertas()
    {
        return $this->hasMany(
            Alerta::class,
            'id_estacion',
            'id_estacion'
        );
    }

    // Calcular porcentaje de ocupación
    public function porcentajeOcupacion()
    {
        if ($this->capacidad_maxima <= 0) {
            return 0;
        }

        return ($this->pasajeros_actuales / $this->capacidad_maxima) * 100;
    }

    // Verificar si se alcanza el límite de alerta
    public function requiereAlerta()
    {
        if ($this->capacidad_maxima <= 0) {
            return false;
        }

        return $this->pasajeros_actuales >=
            ($this->capacidad_maxima * 1.5);
    }
}
