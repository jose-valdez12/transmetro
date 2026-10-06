<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    use HasFactory;
    protected $table = 'alertas';

    protected $fillable = [
        'recorrido_id',
        'estacion_id',
        'tipo',
        'descripcion',
        'estado'
    ];

    public function recorrido()
    {
        return $this->belongsTo(Recorrido::class);
    }

    public function estacion()
    {
        return $this->belongsTo(Estacion::class);
    }
}
