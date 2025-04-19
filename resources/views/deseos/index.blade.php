@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            Mis Deseos
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card mb-4">
                <div class="card-header bg-success text-white">Agregar Nuevo Deseo</div>
                <div class="card-body">
                    <form action="{{ route('deseos.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" name="nombre_deseos" class="form-control" placeholder="Nombre del deseo" required>
                            </div>
                            <div class="col">
                                <input type="text" name="descripcion" class="form-control" placeholder="Descripción" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <select name="id_categoria" class="form-control" required>
                                    <option value="">Selecciona categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <select name="id_estado" class="form-control" required>
                                    <option value="">Selecciona estado</option>
                                    @foreach($estados as $estado)
                                        <option value="{{ $estado->id_estado }}">
                                            {{ $estado->nombre_estado ? 'Pendiente' : 'Cumplido' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="id_usuario" value="{{ auth()->id() }}">
                        <button type="submit" class="btn btn-primary">Agregar Deseo</button>
                    </form>
                </div>
            </div>

            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deseos as $deseo)
                        <tr>
                            <td>{{ $deseo->nombre_deseos }}</td>
                            <td>{{ $deseo->descripcion }}</td>
                            <td>{{ $deseo->categoria->nombre_categoria }}</td>
                            <td>
                                @if($deseo->estado->nombre_estado)
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                @else
                                    <span class="badge bg-success">Cumplido</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('deseos.edit', $deseo->id_deseos) }}" class="btn btn-sm btn-primary">Editar</a>
                                    <form action="{{ route('deseos.destroy', $deseo->id_deseos) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                    @if($deseo->estado->nombre_estado)
                                        <form action="{{ route('deseos.cumplir', $deseo->id_deseos) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Marcar como Cumplido</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No tienes deseos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
