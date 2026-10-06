<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Acceso extends Model
{
    use HasFactory;

    protected $table = 'accesos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estacion_id'
    ];

    public function estacion()
    {
        return $this->belongsTo(Estacion::class);
    }

    public function asignacionesGuardia()
    {
        return $this->hasMany(AsignacionGuardia::class);
    }
}
