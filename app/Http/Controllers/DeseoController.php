<?php

namespace App\Http\Controllers;

use App\Models\Deseo;
use App\Models\Categoria;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DeseoController extends Controller
{
    // Obtener el ID del usuario autenticado (método reutilizable)
    protected function getUserId()
    {
        return Auth::id(); // Forma correcta de obtener el ID del usuario
    }

    // Mostrar lista de deseos del usuario
    public function index()
    {
        $deseos = Deseo::with(['categoria', 'estado'])
                     ->where('id_usuario', $this->getUserId())
                     ->get();

        $categorias = Categoria::all();
        $estados = Estado::all();

        return view('deseos.index', compact('deseos', 'categorias', 'estados'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $categorias = Categoria::all();
        $estados = Estado::all();
        return view('deseos.create', compact('categorias', 'estados'));
    }

    // Guardar nuevo deseo
    public function store(Request $request)
    {
        $request->validate([
            'nombre_deseos' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'id_estado' => 'required|exists:estados,id_estado'
        ]);

        try {
            Deseo::create([
                'nombre_deseos' => $request->nombre_deseos,
                'descripcion' => $request->descripcion,
                'id_categoria' => $request->id_categoria,
                'id_estado' => $request->id_estado,
                'id_usuario' => $this->getUserId()
            ]);

            return redirect()->route('deseos.index')
                   ->with('success', 'Deseo creado correctamente!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear el deseo: ' . $e->getMessage())
                         ->withInput();
        }
    }

    // Mostrar detalles de un deseo
    public function show($id)
    {
        $deseo = Deseo::with(['categoria', 'estado', 'usuario'])
                    ->where('id_usuario', $this->getUserId())
                    ->findOrFail($id);

        return view('deseos.show', compact('deseo'));
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $deseo = Deseo::where('id_usuario', $this->getUserId())
                    ->findOrFail($id);

        $categorias = Categoria::all();
        $estados = Estado::all();

        return view('deseos.edit', compact('deseo', 'categorias', 'estados'));
    }

    // Actualizar un deseo
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre_deseos' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'id_estado' => 'required|exists:estados,id_estado'
        ]);

        try {
            $deseo = Deseo::where('id_usuario', $this->getUserId())
                        ->findOrFail($id);

            $deseo->update($validated);

            return redirect()->route('deseos.index')
                   ->with('success', 'Deseo actualizado correctamente!');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el deseo: ' . $e->getMessage())
                         ->withInput();
        }
    }

    // Eliminar un deseo
    public function destroy($id)
    {
        try {
            $deseo = Deseo::where('id_usuario', $this->getUserId())
                        ->findOrFail($id);

            $deseo->delete();

            return redirect()->route('deseos.index')
                   ->with('success', 'Deseo eliminado correctamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar deseo: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar el deseo');
        }
    }

    // Marcar deseo como cumplido
    public function cumplir($id)
    {
        try {
            $deseo = Deseo::where('id_usuario', $this->getUserId())
                        ->findOrFail($id);

            $estadoCumplido = Estado::where('nombre_estado', false)->first();

            if (!$estadoCumplido) {
                throw new \Exception("Estado 'Cumplido' no encontrado");
            }

            $deseo->update(['id_estado' => $estadoCumplido->id_estado]);

            return redirect()->back()
                   ->with('success', 'Deseo marcado como cumplido.');

        } catch (\Exception $e) {
            Log::error('Error al marcar deseo como cumplido: ' . $e->getMessage());
            return back()->with('error', 'Error al marcar el deseo como cumplido');
        }
    }

    // Métodos API (protegidos por autenticación)
    public function listarDeseos()
    {
        $deseos = Deseo::with(['categoria', 'estado', 'usuario'])
                     ->where('id_usuario', $this->getUserId())
                     ->get();

        return response()->json($deseos);
    }

    // ... (otros métodos API se actualizan de la misma manera)
}
