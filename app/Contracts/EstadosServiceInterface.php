<?php

namespace App\Contracts;

use App\Models\Estados;

interface EstadosServiceInterface
{
    public function listarEstados();
    public function crearEstado(array $data);
    public function obtenerEstado(int $id);
    public function actualizarEstado(Estados $estado, array $data);
    public function eliminarEstado(Estados $estado);
}
