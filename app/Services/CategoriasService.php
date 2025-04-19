<?php

namespace App\Services;

use App\Contracts\CategoriasServiceInterface;
use App\Models\Categorias;

class CategoriasService implements CategoriasServiceInterface
{
    public function listarCategoria()
    {
        return Categorias::all();
    }

    public function crearCategoria(array $data)
    {
        return Categorias::create($data);
    }

    public function obtenerCategoria(int $id)
    {
        return Categorias::findOrFail($id);
    }

    public function actualizarCategoria(Categorias $categoria, array $data)
    {
        $categoria->update($data);
        return $categoria;
    }

    public function eliminarCategoria(Categorias $categoria)
    {
        return $categoria->delete();
    }
}
