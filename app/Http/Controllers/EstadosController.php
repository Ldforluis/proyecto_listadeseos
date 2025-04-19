<?php

namespace App\Http\Controllers;

use App\Contracts\EstadosServiceInterface;
use Illuminate\Http\Request;
use App\Models\Estados;

class EstadosController extends Controller
{
    protected $estadoService;

    public function __construct(EstadosServiceInterface $estadoService)
    {
        $this->estadoService = $estadoService;
    }

    public function index()
    {
        $estados = $this->estadoService->listarEstados();
        return view('estados.index', compact('estados'));
    }

    public function create()
    {
        return view('estados.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:estados',
        ]);

        $this->estadoService->crearEstado($request->all());

        return redirect()->route('estados.index')
                        ->with('success', 'Estado creado exitosamente.');
    }

    public function show($id)
    {
        $estado = $this->estadoService->obtenerEstado($id);
        return view('estados.show', compact('estado'));
    }

    public function edit($id)
    {
        $estado = $this->estadoService->obtenerEstado($id);
        return view('estados.edit', compact('estado'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|unique:estados,nombre,' . $id,
        ]);

        $estado = $this->estadoService->obtenerEstado($id);
        $this->estadoService->actualizarEstado($estado, $request->all());

        return redirect()->route('estados.index')
                        ->with('success', 'Estado actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $estado = $this->estadoService->obtenerEstado($id);
        $this->estadoService->eliminarEstado($estado);

        return redirect()->route('estados.index')
                        ->with('success', 'Estado eliminado exitosamente.');
    }
}
