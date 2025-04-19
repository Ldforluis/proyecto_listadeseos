<?php

namespace App\Http\Controllers;

use App\Contracts\UsuariosServiceInterface;
use Illuminate\Http\Request;
use App\Models\Usuarios;

class UsuariosController extends Controller
{
    protected $usuarioService;

    public function __construct(UsuariosServiceInterface $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function index()
    {
        $usuarios = $this->usuarioService->listarUsuarios();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:usuarios',
            'password' => 'required|min:6',
        ]);

        $this->usuarioService->crearUsuario($request->all());

        return redirect()->route('usuarios.index')
                        ->with('success', 'Usuario creado exitosamente.');
    }

    public function show($id)
    {
        $usuario = $this->usuarioService->obtenerUsuario($id);
        return view('usuarios.show', compact('usuario'));
    }

    public function edit($id)
    {
        $usuario = $this->usuarioService->obtenerUsuario($id);
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => 'required|email|unique:usuarios,email,' . $id,
        ]);

        $usuario = $this->usuarioService->obtenerUsuario($id);
        $this->usuarioService->actualizarUsuario($usuario, $request->all());

        return redirect()->route('usuarios.index')
                        ->with('success', 'Usuario actualizado exitosamente.');
    }
}

