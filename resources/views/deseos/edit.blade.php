@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm bg-gray-50">
                <div class="card-header bg-gray-100 border-0 py-4">
                    <h3 class="text-gray-800 text-center mb-0">
                        <i class="fas fa-pencil-alt mr-2 text-gray-600"></i>
                        Editor de Deseo
                    </h3>
                </div>

                <div class="card-body px-4 py-4">
                    <form action="{{ route('deseos.update', $deseo->id_deseos) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Sección Nombre -->
                        <div class="mb-5">
                            <h4 class="text-gray-700 mb-3 font-weight-normal">
                                <i class="fas fa-heading mr-2 text-gray-500"></i>
                                Nombre del Deseo
                            </h4>
                            <input type="text"
                                   class="form-control border-gray-300 bg-white rounded-lg px-3 py-2 text-gray-700"
                                   value="{{ old('nombre_deseos', $deseo->nombre_deseos) }}"
                                   name="nombre_deseos" required>
                        </div>

                        <!-- Sección Descripción -->
                        <div class="mb-5">
                            <h4 class="text-gray-700 mb-3 font-weight-normal">
                                <i class="fas fa-align-left mr-2 text-gray-500"></i>
                                Descripción
                            </h4>
                            <textarea class="form-control border-gray-300 bg-white rounded-lg px-3 py-2 text-gray-700"
                                      rows="4"
                                      name="descripcion"
                                      style="min-height: 120px; resize: none;"
                                      required>{{ old('descripcion', $deseo->descripcion) }}</textarea>
                        </div>

                        <!-- Sección Categoría y Estado -->
                        <div class="row mb-5">
                            <div class="col-md-6">
                                <h4 class="text-gray-700 mb-3 font-weight-normal">
                                    <i class="fas fa-tag mr-2 text-gray-500"></i>
                                    Categoría
                                </h4>
                                <select class="form-control border-gray-300 bg-white rounded-lg px-3 py-2 text-gray-700"
                                        name="id_categoria" required>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}"
                                            {{ $deseo->id_categoria == $categoria->id_categoria ? 'selected' : '' }}>
                                            {{ $categoria->nombre_categoria }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <h4 class="text-gray-700 mb-3 font-weight-normal">
                                    <i class="fas fa-check-circle mr-2 text-gray-500"></i>
                                    Estado
                                </h4>
                                <select class="form-control border-gray-300 bg-white rounded-lg px-3 py-2 text-gray-700"
                                        name="id_estado" required>
                                    @foreach($estados as $estado)
                                        <option value="{{ $estado->id_estado }}"
                                            {{ $deseo->id_estado == $estado->id_estado ? 'selected' : '' }}>
                                            {{ $estado->nombre_estado ? 'Pendiente' : 'Cumplido' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="d-flex justify-content-between border-top pt-4">
                            <a href="{{ route('deseos.index') }}"
                               class="btn btn-outline-gray-500 rounded-pill px-4 py-2">
                                <i class="fas fa-times mr-2"></i>
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="btn bg-gray-700 text-white rounded-pill px-4 py-2 hover:bg-gray-800">
                                <i class="fas fa-save mr-2"></i>
                                Actualizar Deseo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gray-50 { background-color: #f9fafb; }
    .bg-gray-100 { background-color: #f3f4f6; }
    .bg-gray-700 { background-color: #374151; }
    .bg-gray-800 { background-color: #1f2937; }

    .text-gray-500 { color: #6b7280; }
    .text-gray-600 { color: #4b5563; }
    .text-gray-700 { color: #374151; }
    .text-gray-800 { color: #1f2937; }

    .border-gray-300 { border-color: #d1d5db; }

    .btn-outline-gray-500 {
        color: #6b7280;
        border-color: #d1d5db;
    }

    .btn-outline-gray-500:hover {
        background-color: #f3f4f6;
        color: #374151;
    }

    .hover\:bg-gray-800:hover {
        background-color: #1f2937;
    }

    .card {
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .form-control {
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus {
        border-color: #9ca3af;
        box-shadow: 0 0 0 0.2rem rgba(156, 163, 175, 0.25);
    }

    .rounded-lg {
        border-radius: 0.375rem;
    }

    .rounded-pill {
        border-radius: 50rem;
    }
</style>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endsection
