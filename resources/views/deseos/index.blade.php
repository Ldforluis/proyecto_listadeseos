@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Mis Deseos</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWishModal">
                <i class="fas fa-plus me-1"></i> Nuevo Deseo
            </button>
        </div>

        <!-- Lista de Deseos -->
        <div class="row">
            @forelse($deseos as $deseo)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 wish-card @if(!$deseo->estado->nombre_estado) completed @endif">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $deseo->nombre_deseos }}</h5>
                                <span class="badge rounded-pill
                                    @if($deseo->estado->nombre_estado) bg-warning text-dark @else bg-success @endif">
                                    @if($deseo->estado->nombre_estado) Pendiente @else Cumplido @endif
                                </span>
                            </div>
                            <p class="card-text text-muted">{{ $deseo->descripcion }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-tag me-1"></i> {{ $deseo->categoria->nombre_categoria }}
                                </span>
                                <div class="btn-group">
                                    <a href="{{ route('deseos.edit', $deseo->id_deseos) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger delete-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-route="{{ route('deseos.destroy', $deseo->id_deseos) }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @if($deseo->estado->nombre_estado)
                                        <form action="{{ route('deseos.cumplir', $deseo->id_deseos) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-gift fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No tienes deseos registrados</h5>
                            <p class="text-muted">Comienza agregando tu primer deseo</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWishModal">
                                <i class="fas fa-plus me-1"></i> Agregar Deseo
                            </button>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal para agregar nuevo deseo -->
    <div class="modal fade" id="addWishModal" tabindex="-1" aria-labelledby="addWishModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWishModalLabel">Agregar Nuevo Deseo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('deseos.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre_deseos" class="form-label">Nombre del Deseo</label>
                            <input type="text" class="form-control" id="nombre_deseos" name="nombre_deseos" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="id_categoria" class="form-label">Categoría</label>
                                <select class="form-select" id="id_categoria" name="id_categoria" required>
                                    <option value="">Selecciona categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre_categoria }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="id_estado" class="form-label">Estado</label>
                                <select class="form-select" id="id_estado" name="id_estado" required>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Deseo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación para Eliminar -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este deseo? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configura el modal para eliminar
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('deleteForm').action = this.getAttribute('data-route');
                });
            });

            // Animación para las tarjetas
            const wishCards = document.querySelectorAll('.wish-card');
            wishCards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-5px)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = '';
                });
            });
        });
    </script>
    @endpush
@endsection
