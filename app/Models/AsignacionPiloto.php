<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AsignacionPiloto extends Model
{
    use HasFactory;

    protected $table = 'asignaciones_piloto';

    protected $primaryKey = 'id_asignacion_piloto';

    protected $fillable = [
        'id_piloto',
        'id_bus',
        'fecha_inicio',
        'fecha_fin',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'estado' => 'boolean'
    ];

    // Relación con el piloto
    public function piloto()
    {
        return $this->belongsTo(
            Piloto::class,
            'id_piloto',
            'id_piloto'
        );
    }

    // Relación con el bus
    public function bus()
    {
        return $this->belongsTo(
            Bus::class,
            'id_bus',
            'id_bus'
        );
    }
}
