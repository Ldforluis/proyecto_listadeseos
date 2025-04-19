@extends('layouts.app')

@section('title', 'Mi Lista de Deseos')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0"><i class="fas fa-list-alt me-2"></i>Mi Lista de Deseos</h1>
        <a href="{{ route('deseos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Agregar Deseo
        </a>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('deseos.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="category" class="form-label">Categoría</label>
                        <select class="form-select" id="category" name="category">
                            <option value="">Todas las categorías</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label">Estado</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Todos los estados</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                                    {{ $status->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="priority" class="form-label">Prioridad</label>
                        <select class="form-select" id="priority" name="priority">
                            <option value="">Todas las prioridades</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Alta</option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Media</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Baja</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" class="form-control" id="search" name="search"
                               placeholder="Buscar deseos..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-filter me-1"></i> Filtrar
                        </button>
                        <a href="{{ route('deseos.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-undo me-1"></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de deseos -->
    @if($wishes->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> No tienes deseos registrados. ¡Agrega tu primer deseo!
        </div>
    @else
        <div class="row">
            @foreach($wishes as $wish)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card card-wish h-100 priority-{{ $wish->priority_class }}">
                        @if($wish->imagen)
                            <img src="{{ asset('storage/' . $wish->imagen) }}" class="wish-image" alt="{{ $wish->titulo }}">
                        @else
                            <div class="wish-image bg-light d-flex align-items-center justify-content-center">
                                <i class="fas fa-gift fa-4x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $wish->titulo }}</h5>
                                <span class="badge badge-category rounded-pill">
                                    {{ $wish->categoria->nombre }}
                                </span>
                            </div>
                            <p class="card-text text-muted">{{ Str::limit($wish->descripcion, 100) }}</p>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                @if($wish->precio_estimado)
                                    <span class="text-primary fw-bold">${{ number_format($wish->precio_estimado, 2) }}</span>
                                @else
                                    <span class="text-muted">Sin precio estimado</span>
                                @endif

                                <span class="badge bg-{{ $wish->estado->nombre == 'cumplido' ? 'success' : 'warning' }}">
                                    {{ $wish->estado->nombre }}
                                </span>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('deseos.show', $wish->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('deseos.edit', $wish->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($wish->estado->nombre != 'cumplido')
                                    <form action="{{ route('deseos.marcar-cumplido', $wish->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i> Cumplido
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('deseos.destroy', $wish->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este deseo?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-center">
            {{ $wishes->links() }}
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Scripts adicionales si son necesarios
    document.addEventListener('DOMContentLoaded', function() {
        // Puedes añadir interactividad aquí
    });
</script>
@endsection
