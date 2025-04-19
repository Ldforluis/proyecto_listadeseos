<?php

namespace App\Services;

use App\Contracts\EstadosServiceInterface;
use App\Models\Estados;

class EstadosService implements EstadosServiceInterface
{
    public function listarEstados()
    {
        return Estados::all();
    }

    public function crearEstado(array $data)
    {
        return Estados::create($data);
    }

    public function obtenerEstado(int $id)
    {
        return Estados::findOrFail($id);
    }

    public function actualizarEstado(Estados $estado, array $data)
    {
        $estado->update($data);
        return $estado;
    }

    public function eliminarEstado(Estados $estado)
    {
        return $estado->delete();
    }
}
