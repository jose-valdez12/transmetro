<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Recorrido extends Model
{
        use HasFactory;

    protected $table = 'recorridos';

    protected $fillable = [
        'bus_id',
        'linea_id',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function linea()
    {
        return $this->belongsTo(Linea::class);
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

