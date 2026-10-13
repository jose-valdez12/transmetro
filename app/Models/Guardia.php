<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guardia extends Model
{
    use HasFactory;

    protected $table = 'guardias';

    protected $primaryKey = 'id_guardia';

    protected $fillable = [
        'nombres',
        'apellidos',
        'telefono',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean'
    ];

    // Relación con las asignaciones de guardias
    public function asignaciones()
    {
        return $this->hasMany(
            AsignacionGuardia::class,
            'id_guardia',
            'id_guardia'
        );
    }
}
