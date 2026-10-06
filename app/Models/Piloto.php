<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Piloto extends Model
{
    use HasFactory;

    protected $table = 'pilotos';

    protected $fillable = [
        'nombre',
        'apellido',
        'dpi',
        'telefono',
        'correo',
        'direccion'
    ];

    public function formaciones()
    {
        return $this->hasMany(FormacionPiloto::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(AsignacionPiloto::class);
    }
}
