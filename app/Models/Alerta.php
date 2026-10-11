<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    use HasFactory;

    // Tabla de la base de datos
    protected $table = 'alertas';

    // Clave primaria
    protected $primaryKey = 'id_alerta';

    // Campos permitidos para registrar y actualizar
    protected $fillable = [
        'id_recorrido',
        'id_estacion',
        'tipo',
        'descripcion',
        'fecha_hora',
        'estado'
    ];

    // Conversión de tipos de datos
    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    // Relación: una alerta pertenece a un recorrido
    public function recorrido()
    {
        return $this->belongsTo(
            Recorrido::class,
            'id_recorrido',
            'id_recorrido'
        );
    }

    // Relación: una alerta pertenece a una estación
    public function estacion()
    {
        return $this->belongsTo(
            Estacion::class,
            'id_estacion',
            'id_estacion'
        );
    }

    // Consultar únicamente alertas pendientes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'Pendiente');
    }

    // Consultar únicamente alertas atendidas
    public function scopeAtendidas($query)
    {
        return $query->where('estado', 'Atendida');
    }
}
