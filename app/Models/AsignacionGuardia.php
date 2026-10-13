<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AsignacionGuardia extends Model
{
    use HasFactory;

    protected $table = 'asignaciones_guardia';

    protected $primaryKey = 'id_asignacion_guardia';

    protected $fillable = [
        'id_guardia',
        'id_acceso',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'estado' => 'boolean'
    ];

    // Relación con el guardia
    public function guardia()
    {
        return $this->belongsTo(
            Guardia::class,
            'id_guardia',
            'id_guardia'
        );
    }

    // Relación con el acceso
    public function acceso()
    {
        return $this->belongsTo(
            Acceso::class,
            'id_acceso',
            'id_acceso'
        );
    }
}
