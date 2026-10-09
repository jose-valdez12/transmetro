<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Estacion;
use App\Models\AsignacionGuardia;

class Acceso extends Model
{
    use HasFactory;

    protected $table = 'accesos';

    protected $primaryKey = 'id_acceso';

    protected $fillable = [
        'nombre',
        'id_estacion',
        'estado'
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    public function estacion()
    {
        return $this->belongsTo(
            Estacion::class,
            'id_estacion',
            'id_estacion'
        );
    }

    public function asignacionesGuardia()
    {
        return $this->hasMany(
            AsignacionGuardia::class,
            'id_acceso',
            'id_acceso'
        );
    }
}
