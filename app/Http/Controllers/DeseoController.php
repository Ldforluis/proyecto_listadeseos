<?php

namespace App\Http\Controllers;

use App\Models\Deseo;
use App\Models\Categoria;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeseoController extends Controller
{
    public function index()
    {
        $deseos = Deseo::with(['categoria', 'estado', 'usuario'])->get();
        $categorias = Categoria::all();
        $estados = Estado::all();

        return view('deseos.index', compact('deseos', 'categorias', 'estados'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $estados = Estado::all();
        return view('deseos.create', compact('categorias', 'estados'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nombre_deseos' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'id_categoria' => 'required|exists:categorias,id_categoria',
        'id_estado' => 'required|exists:estados,id_estado',
        'id_usuario' => 'required|exists:users,id'
    ]);

    try {
        $deseo = Deseo::create([
            'nombre_deseos' => $request->nombre_deseos,
            'descripcion' => $request->descripcion,
            'id_categoria' => $request->id_categoria,
            'id_estado' => $request->id_estado,
            'id_usuario' => $request->id_usuario
        ]);

        return redirect()->route('deseos.index')
               ->with('success', 'Deseo creado correctamente!');

    } catch (\Exception $e) {
        return back()->with('error', 'Error al crear el deseo: '.$e->getMessage())
                     ->withInput();
    }
}

    public function show($id)
    {
        $deseo = Deseo::with(['categoria', 'estado', 'usuario'])->findOrFail($id);
        return view('deseos.show', compact('deseo'));
    }

    public function edit($id)
    {
        $deseo = Deseo::findOrFail($id);
        $categorias = Categoria::all();
        $estados = Estado::all();
        return view('deseos.edit', compact('deseo', 'categorias', 'estados'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre_deseos' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'id_estado' => 'required|exists:estados,id_estado',
            'id_usuario' => 'required|exists:users,id'
        ]);

        try {
            DB::beginTransaction();

            $deseo = Deseo::findOrFail($id);
            $deseo->update($validated);

            DB::commit();

            return redirect()->route('deseos.index')
                   ->with('success', 'Deseo actualizado correctamente!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar deseo: ' . $e->getMessage());
            return back()->with('error', 'Error al actualizar el deseo')
                         ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $deseo = Deseo::findOrFail($id);
            $deseo->delete();

            return redirect()->route('deseos.index')
                   ->with('success', 'Deseo eliminado correctamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar deseo: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar el deseo');
        }
    }

    public function cumplir($id)
    {
        try {
            $deseo = Deseo::findOrFail($id);
            $estadoCumplido = Estado::where('nombre_estado', false)->firstOrFail();

            $deseo->update(['id_estado' => $estadoCumplido->id_estado]);

            return redirect()->back()
                   ->with('success', 'Deseo marcado como cumplido.');

        } catch (\Exception $e) {
            Log::error('Error al marcar deseo como cumplido: ' . $e->getMessage());
            return back()->with('error', 'Error al marcar el deseo como cumplido');
        }
    }

    // Métodos API
    public function listarDeseos()
    {
        return response()->json(Deseo::with(['categoria', 'estado', 'usuario'])->get());
    }

    public function obtenerDeseo($id)
    {
        return response()->json(Deseo::with(['categoria', 'estado', 'usuario'])->findOrFail($id));
    }

    public function crearDeseo(Request $request)
    {
        $validated = $request->validate([
            'nombre_deseos' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'id_estado' => 'required|exists:estados,id_estado',
            'id_usuario' => 'required|exists:users,id'
        ]);

        $deseo = Deseo::create($validated);
        return response()->json($deseo, 201);
    }

    public function actualizarDeseo(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre_deseos' => 'sometimes|string|max:255',
            'descripcion' => 'sometimes|string',
            'id_categoria' => 'sometimes|exists:categorias,id_categoria',
            'id_estado' => 'sometimes|exists:estados,id_estado',
            'id_usuario' => 'sometimes|exists:users,id'
        ]);

        $deseo = Deseo::findOrFail($id);
        $deseo->update($validated);
        return response()->json($deseo);
    }

    public function eliminarDeseo($id)
    {
        Deseo::findOrFail($id)->delete();
        return response()->json(null, 204);
    }

    public function listarDeseosPorUsuario($id_usuario)
    {
        $deseos = Deseo::with(['categoria', 'estado'])
                     ->where('id_usuario', $id_usuario)
                     ->get();
        return response()->json($deseos);
    }

    public function listarDeseosPorCategoria($id_categoria)
    {
        $deseos = Deseo::with(['estado', 'usuario'])
                      ->where('id_categoria', $id_categoria)
                      ->get();
        return response()->json($deseos);
    }

    public function listarDeseosPorEstado($id_estado)
    {
        $deseos = Deseo::with(['categoria', 'usuario'])
                      ->where('id_estado', $id_estado)
                      ->get();
        return response()->json($deseos);
    }

    public function listarDeseosCumplidos()
    {
        $deseos = Deseo::with(['categoria', 'usuario'])
                     ->whereHas('estado', function($q) {
                         $q->where('nombre_estado', false);
                     })
                     ->get();
        return response()->json($deseos);
    }

    public function listarDeseosNoCumplidos()
    {
        $deseos = Deseo::with(['categoria', 'usuario'])
                      ->whereHas('estado', function($q) {
                          $q->where('nombre_estado', true);
                      })
                      ->get();
        return response()->json($deseos);
    }
}
