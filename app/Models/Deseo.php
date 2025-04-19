<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deseo extends Model
{
    protected $primaryKey = 'id_deseos';

    protected $fillable = [
        'nombre_deseos',
        'descripcion',
        'id_categoria',
        'id_estado',
        'id_usuario'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    // Añade esta relación
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
