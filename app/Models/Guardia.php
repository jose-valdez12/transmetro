<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guardia extends Model
{
    use HasFactory;

    protected $table = 'guardias';

    protected $fillable = [
        'nombre',
        'apellido',
        'dpi',
        'telefono',
        'correo',
        'direccion'
    ];

    public function asignaciones()
    {
        return $this->hasMany(AsignacionGuardia::class);
    }
}
