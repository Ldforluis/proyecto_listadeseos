<?php

namespace App\Contracts;

use App\Models\Deseos;

interface DeseosServiceInterface
{
    public function listarDeseos();
    public function crearDeseo(array $data);
    public function obtenerDeseo(int $id);
    public function actualizarDeseo(Deseos $deseo, array $data);
    public function eliminarDeseo(Deseos $deseo);
}
