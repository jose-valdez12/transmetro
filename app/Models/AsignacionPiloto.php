<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AsignacionPiloto extends Model
{
    use HasFactory;

    protected $table = 'asignaciones_piloto';

    protected $fillable = [
        'piloto_id',
        'bus_id',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    public function piloto()
    {
        return $this->belongsTo(Piloto::class);
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
