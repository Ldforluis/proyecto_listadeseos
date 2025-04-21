@extends('layouts.app')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2 fs-4"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Botones de inicio de sesión y registro para usuarios no autenticados -->
        @guest
        <div class="text-end mb-4 animate__animated animate__fadeIn">
            <div class="btn-group" role="group">
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-hover-scale">
                    <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-hover-scale">
                    <i class="fas fa-user-plus me-1"></i> Registrarse
                </a>
            </div>
        </div>
        @endguest

        <div class="d-flex justify-content-between align-items-center mb-4 animate__animated animate__fadeIn">
            <h1 class="h3 mb-0 text-gradient">Mis Deseos</h1>
            @auth
            <button class="btn btn-primary btn-hover-grow" data-bs-toggle="modal" data-bs-target="#addWishModal">
                <i class="fas fa-plus me-1"></i> Nuevo Deseo
            </button>
            @endauth
        </div>

        <!-- Lista de Deseos -->
        <div class="row">
            @forelse($deseos as $deseo)
                <div class="col-md-6 col-lg-4 mb-4 animate__animated animate__fadeInUp" style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <div class="card h-100 wish-card @if(!$deseo->estado->nombre_estado) completed @endif">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $deseo->nombre_deseos }}</h5>
                                <span class="badge rounded-pill pulse @if($deseo->estado->nombre_estado) bg-warning text-dark @else bg-success @endif">
                                    @if($deseo->estado->nombre_estado) Pendiente @else Cumplido @endif
                                </span>
                            </div>
                            <p class="card-text text-muted">{{ $deseo->descripcion }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-light text-dark category-badge">
                                    <i class="fas fa-tag me-1"></i> {{ $deseo->categoria->nombre_categoria }}
                                </span>
                                @auth
                                <div class="btn-group">
                                    <a href="{{ route('deseos.edit', $deseo->id_deseos) }}"
                                       class="btn btn-sm btn-outline-primary btn-icon" data-bs-toggle="tooltip" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger btn-icon delete-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal"
                                            data-route="{{ route('deseos.destroy', $deseo->id_deseos) }}"
                                            data-bs-toggle="tooltip" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @if($deseo->estado->nombre_estado)
                                        <form action="{{ route('deseos.cumplir', $deseo->id_deseos) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success btn-icon" data-bs-toggle="tooltip" title="Marcar como cumplido">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 animate__animated animate__fadeIn">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-gift fa-3x text-muted mb-3 animate__animated animate__pulse animate__infinite" style="animation-duration: 2s"></i>
                            <h5 class="text-muted">No tienes deseos registrados</h5>
                            <p class="text-muted">Comienza agregando tu primer deseo</p>
                            @auth
                            <button class="btn btn-primary btn-hover-grow" data-bs-toggle="modal" data-bs-target="#addWishModal">
                                <i class="fas fa-plus me-1"></i> Agregar Deseo
                            </button>
                            @else
                            <div class="btn-group">
                                <a href="{{ route('login') }}" class="btn btn-primary btn-hover-scale">
                                    <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-hover-scale">
                                    <i class="fas fa-user-plus me-1"></i> Registrarse
                                </a>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    @auth
    <!-- Modal para agregar nuevo deseo (solo para usuarios autenticados) -->
    <div class="modal fade" id="addWishModal" tabindex="-1" aria-labelledby="addWishModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addWishModalLabel">
                        <i class="fas fa-plus-circle me-2"></i> Agregar Nuevo Deseo
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('deseos.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre_deseos" class="form-label">Nombre del Deseo</label>
                            <input type="text" class="form-control form-control-lg" id="nombre_deseos" name="nombre_deseos" required placeholder="Ej: Viaje a París">
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required placeholder="Describe tu deseo..."></textarea>
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
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary btn-hover-grow">
                            <i class="fas fa-save me-1"></i> Guardar Deseo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación para Eliminar -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Confirmar Eliminación
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-trash-alt fa-4x text-danger mb-3 animate__animated animate__headShake animate__infinite" style="animation-duration: 3s"></i>
                        <h5>¿Estás seguro de que deseas eliminar este deseo?</h5>
                        <p class="text-muted">Esta acción no se puede deshacer y perderás toda la información asociada.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-hover-grow">
                            <i class="fas fa-trash me-1"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endauth

    @push('styles')
    <style>
        /* Efecto de gradiente para textos */
        .text-gradient {
            background: linear-gradient(45deg, #3f51b5, #9c27b0);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        /* Efecto de hover para botones */
        .btn-hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .btn-hover-scale:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .btn-hover-grow {
            transition: all 0.3s ease;
        }
        
        .btn-hover-grow:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        /* Efecto de pulso para los badges */
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        /* Estilo para tarjetas */
        .wish-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .wish-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }
        
        /* Estilo para botones de icono */
        .btn-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50% !important;
            transition: all 0.3s ease;
        }
        
        .btn-icon:hover {
            transform: scale(1.1);
        }
        
        /* Estilo para categorías */
        .category-badge {
            border: 1px solid #dee2e6;
            padding: 5px 10px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        
        .category-badge:hover {
            background-color: #f8f9fa !important;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configura el modal para eliminar
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('deleteForm').action = this.getAttribute('data-route');
                });
            });

            // Inicializar tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    @endpush
@endsection