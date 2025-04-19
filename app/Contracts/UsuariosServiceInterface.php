<?php

namespace App\Contracts;

use App\Models\Usuarios;

interface UsuariosServiceInterface
{
    public function listarUsuarios();
    public function crearUsuario(array $data);
    public function obtenerUsuario(int $id);
    public function actualizarUsuario(Usuarios $usuario, array $data);
    public function eliminarUsuario(Usuarios $usuario);
}
