<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AsignacionBusLinea extends Model
{
    use HasFactory;

    protected $table = 'asignaciones_bus_linea';

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
}
