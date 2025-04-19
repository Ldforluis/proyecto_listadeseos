<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deseos extends Model
{
    use HasFactory;

    protected $table = 'deseos';
    protected $primaryKey = 'id_deseo';

    protected $fillable = [
        'id_usuario',
        'id_categoria',
        'id_estado',
        'nombre_deseo',
        'descripcion',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario');
    }

    public function categoria()
    {
        return $this->belongsTo(Categorias::class, 'id_categoria');
    }

    public function estado()
    {
        return $this->belongsTo(Estados::class, 'id_estado');
    }

    public function marcarCumplido()
    {
        $estadoCumplido = Estados::where('nombre_estado', 'Cumplido')->first();

        if ($estadoCumplido) {
            $this->id_estado = $estadoCumplido->id_estado;
            $this->save();
        }
    }
}
