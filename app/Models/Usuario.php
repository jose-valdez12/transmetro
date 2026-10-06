<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
 use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'correo',
        'password',
        'rol',
        'estado'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function getAuthPasswordName()
    {
        return 'password';
    }

    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }
}
