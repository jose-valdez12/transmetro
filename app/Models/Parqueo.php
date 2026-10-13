<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parqueo extends Model
{
    use HasFactory;

    protected $table = 'parqueos';

    protected $primaryKey = 'id_parqueo';

    protected $fillable = [
        'codigo',
        'estado'
    ];
}
