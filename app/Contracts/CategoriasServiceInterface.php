<?php

namespace App\Contracts;

use App\Http\Controllers\CategoriasController;
use App\Models\Categorias;

interface CategoriasServiceInterface
{
    public function listarCategoria();
    public function crearCategoria(array $data);
    public function obtenerCategoria(int $id);
    public function actualizarCategoria(Categorias $categoria, array $data);
    public function eliminarCategoria(Categorias $categoria);
}
