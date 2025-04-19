<?php

namespace App\Http\Controllers;

use App\Contracts\DeseosServiceInterface;
use Illuminate\Http\Request;
use App\Models\Deseos;

class DeseosController extends Controller
{
    protected $deseoService;

    public function __construct(DeseosServiceInterface $deseoService)
    {
        $this->deseoService = $deseoService;
    }

    public function index()
    {
        $deseos = $this->deseoService->listarDeseos();
        return view('deseos.index', compact('deseos'));
    }

    public function create()
    {
        return view('deseos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $this->deseoService->crearDeseo($request->all());

        return redirect()->route('deseos.index')
                        ->with('success', 'Deseo creado exitosamente.');
    }

    public function show($id)
    {
        $deseo = $this->deseoService->obtenerDeseo($id);
        return view('deseos.show', compact('deseo'));
    }

    public function edit($id)
    {
        $deseo = $this->deseoService->obtenerDeseo($id);
        return view('deseos.edit', compact('deseo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required',
        ]);

        $deseo = $this->deseoService->obtenerDeseo($id);
        $this->deseoService->actualizarDeseo($deseo, $request->all());

        return redirect()->route('deseos.index')
                        ->with('success', 'Deseo actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $deseo = $this->deseoService->obtenerDeseo($id);
        $this->deseoService->eliminarDeseo($deseo);

        return redirect()->route('deseos.index')
                        ->with('success', 'Deseo eliminado exitosamente.');
    }
}
