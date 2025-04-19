<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\CategoriasServiceInterface;

class CategoriasController extends Controller
{
    protected $categoriaService;

    public function __construct(CategoriasServiceInterface $categoriaService)
    {
        $this->categoriaService = $categoriaService;
    }

    public function index()
    {
        return response()->json($this->categoriaService->listarCategoria());
    }

    public function store(Request $request)
    {
        return response()->json($this->categoriaService->crearCategoria($request->all()));
    }

    public function show($id)
    {
        return response()->json($this->categoriaService->obtenerCategoria($id));
    }

    public function update(Request $request, $id)
    {
        return response()->json($this->categoriaService->actualizarCategoria($id, $request->all()));
    }

    public function destroy($id)
    {
        return response()->json($this->categoriaService->eliminarCategoria($id));
    }
}
