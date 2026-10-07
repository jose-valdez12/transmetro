<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'municipios';

    protected $primaryKey = 'id_municipio';

    protected $fillable = [
        'nombre',
        'departamento',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];
}
