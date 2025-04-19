<?php

namespace App\Services;

use App\Contracts\UsuariosServiceInterface;
use App\Models\Usuarios;

class UsuariosService implements UsuariosServiceInterface
{
    public function listarUsuarios()
    {
        return Usuarios::all();
    }

    public function crearUsuario(array $data)
    {
        return Usuarios::create($data);
    }

    public function obtenerUsuario(int $id)
    {
        return Usuarios::findOrFail($id);
    }

    public function actualizarUsuario(Usuarios $usuario, array $data)
    {
        $usuario->update($data);
        return $usuario;
    }

    public function eliminarUsuario(Usuarios $usuario)
    {
        return $usuario->delete();
    }
}
