<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitaEstacion extends Model
{
    use HasFactory;

    protected $table = 'visitas_estacion';

    protected $fillable = [
        'recorrido_id',
        'estacion_id',
        'fecha_llegada',
        'fecha_salida',
        'pasajeros'
    ];

    public function recorrido()
    {
        return $this->belongsTo(Recorrido::class);
    }

    public function estacion()
    {
        return $this->belongsTo(Estacion::class);
    }
}
