<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AsignacionGuardia extends Model
{
    use HasFactory;

    protected $table = 'asignaciones_guardia';

    protected $fillable = [
        'guardia_id',
        'acceso_id',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    public function guardia()
    {
        return $this->belongsTo(Guardia::class);
    }

    public function acceso()
    {
        return $this->belongsTo(Acceso::class);
    }
}
