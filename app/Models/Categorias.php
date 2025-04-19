<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';

    protected $fillable = [
        'nombre_categoria',
    ];

    public function deseos()
    {
        return $this->hasMany(Deseos::class, 'id_categoria');
    }
}
