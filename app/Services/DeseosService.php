<?php

namespace App\Services;

use App\Contracts\DeseosServiceInterface;
use App\Models\Deseos;

class DeseosService implements DeseosServiceInterface
{
    public function listarDeseos()
    {
        return Deseos::all();
    }

    public function crearDeseo(array $data)
    {
        return Deseos::create($data);
    }

    public function obtenerDeseo(int $id)
    {
        return Deseos::findOrFail($id);
    }

    public function actualizarDeseo(Deseos $deseo, array $data)
    {
        $deseo->update($data);
        return $deseo;
    }

    public function eliminarDeseo(Deseos $deseo)
    {
        return $deseo->delete();
    }
}
