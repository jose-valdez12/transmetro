<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Municipio extends Model
{
    use HasFactory;

    protected $table = 'municipios';

    protected $fillable = [
        'nombre',
        'departamento'
    ];

    public function lineas()
    {
        return $this->hasMany(Linea::class);
    }

    public function estaciones()
    {
        return $this->hasMany(Estacion::class);
    }
}
