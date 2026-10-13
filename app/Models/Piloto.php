<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Piloto extends Model
{
    use HasFactory;

    protected $table = 'pilotos';

    protected $primaryKey = 'id_piloto';

    protected $fillable = [
        'nombres',
        'apellidos',
        'telefono',
        'direccion',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean'
    ];

    // Relación con las formaciones del piloto
    public function formaciones()
    {
        return $this->hasMany(
            FormacionPiloto::class,
            'id_piloto',
            'id_piloto'
        );
    }

    // Relación con las asignaciones del piloto
    public function asignaciones()
    {
        return $this->hasMany(
            AsignacionPiloto::class,
            'id_piloto',
            'id_piloto'
        );
    }
}
