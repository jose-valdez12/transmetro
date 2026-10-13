<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormacionPiloto extends Model
{
    use HasFactory;

    protected $table = 'formacion_pilotos';

    protected $primaryKey = 'id_formacion';

    protected $fillable = [
        'id_piloto',
        'institucion',
        'titulo',
        'fecha'
    ];

    protected $casts = [
        'fecha' => 'date'
    ];

    // Cada formación pertenece a un piloto
    public function piloto()
    {
        return $this->belongsTo(
            Piloto::class,
            'id_piloto',
            'id_piloto'
        );
    }
}
