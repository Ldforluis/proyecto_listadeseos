@extends('layout')

@section('title', 'Lista de Usuarios')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h1 class="text-center text-primary mb-4">Lista de Usuarios</h1>

            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Contraseña</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->id_usuario }}</td>
                                <td>{{ $usuario->nombre }}</td>
                                <td>{{ $usuario->correo }}</td>
                                <td>
                                    <span class="badge badge-secondary">Oculto</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
