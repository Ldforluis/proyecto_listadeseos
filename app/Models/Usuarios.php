<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Usuarios extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'correo',
        'contraseña',
    ];

    protected $hidden = [
        'contraseña',
    ];

    public function deseos()
    {
        return $this->hasMany(Deseos::class);
    }
}

