<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormacionPiloto extends Model
{
    use HasFactory;

    protected $table = 'formacion_pilotos';

    protected $fillable = [
        'piloto_id',
        'titulo',
        'institucion',
        'fecha'
    ];

    public function piloto()
    {
        return $this->belongsTo(Piloto::class);
    }
}
