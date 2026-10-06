<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parqueo extends Model
{
    use HasFactory;

    protected $table = 'parqueos';

    protected $fillable = [
        'numero',
        'ubicacion',
        'estado',
        'bus_id'
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }
}
