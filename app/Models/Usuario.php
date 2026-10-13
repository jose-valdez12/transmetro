<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $primaryKey = 'id_usuario';

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

    protected $casts = [
        'estado' => 'boolean',

    ];

    // Campo utilizado para autenticación
    public function getAuthPasswordName()
    {
        return 'password';
    }

    // Correo utilizado para recuperación de contraseña
    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }
}
