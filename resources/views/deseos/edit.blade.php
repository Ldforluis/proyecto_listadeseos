@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Editar Deseo
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('deseos.update', $deseo->id_deseos) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="nombre_deseos">Nombre del Deseo</label>
                            <input type="text" class="form-control" id="nombre_deseos" name="nombre_deseos"
                                   value="{{ old('nombre_deseos', $deseo->nombre_deseos) }}" required>
                            @error('nombre_deseos')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion', $deseo->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="id_categoria">Categoría</label>
                            <select class="form-control" id="id_categoria" name="id_categoria" required>
                                <option value="">Seleccione una categoría</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id_categoria }}"
                                        {{ old('id_categoria', $deseo->id_categoria) == $categoria->id_categoria ? 'selected' : '' }}>
                                        {{ $categoria->nombre_categoria }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_categoria')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="id_estado">Estado</label>
                            <select class="form-control" id="id_estado" name="id_estado" required>
                                <option value="">Seleccione un estado</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id_estado }}"
                                        {{ old('id_estado', $deseo->id_estado) == $estado->id_estado ? 'selected' : '' }}>
                                        {{ $estado->nombre_estado ? 'Pendiente' : 'Cumplido' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_estado')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Actualizar Deseo</button>
                            <a href="{{ route('deseos.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
