<!DOCTYPE html>
<html lang="es" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Deseos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-color: #000000;
            --secondary-color: #f43f5e;
            --light-bg: #f8fafc;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --transition: all 0.3s ease;
            --navbar-height: 60px;
        }

        /* Efecto de luz animada */
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
            background-color: var(--light-bg);
        }

        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background:
                radial-gradient(circle at 70% 30%, rgba(101, 110, 119, 0.788), transparent 30%),
                radial-gradient(circle at 30% 70%, rgb(126, 167, 201), transparent 30%);
            animation: lightMovement 10s linear infinite alternate;
            z-index: -1;
            pointer-events: none;
        }

        @keyframes lightMovement {
            0% { transform: translate(0%, 0%); }
            25% { transform: translate(10%, 15%); }
            50% { transform: translate(20%, 5%); }
            75% { transform: translate(5%, 20%); }
            100% { transform: translate(15%, 10%); }
        }

        /* Barra de navegación con efectos */
        .navbar {
            height: var(--navbar-height);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            background-color: rgba(0, 0, 0, 0.9) !important;
            backdrop-filter: blur(12px);
            transition: all 0.5s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar.scrolled {
            height: calc(var(--navbar-height) - 10px);
            background-color: rgba(0, 0, 0, 0.95) !important;
        }

        .navbar-brand {
            font-weight: 600;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .navbar-brand::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--secondary-color);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.4s ease;
        }

        .navbar-brand:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        .navbar-brand i {
            color: var(--secondary-color);
            transition: all 0.3s ease;
        }

        .navbar-brand:hover i {
            transform: rotate(15deg) scale(1.2);
            text-shadow: 0 0 10px rgba(244, 63, 94, 0.5);
        }

        .nav-link {
            position: relative;
            padding: 0.5rem 1rem;
            margin: 0 0.2rem;
            transition: all 0.3s ease;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--secondary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::before {
            width: 80%;
        }

        .btn-outline-light {
            border-width: 2px;
            font-weight: 500;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            color: #000 !important;
        }

        .btn-outline-light::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: white;
            transition: all 0.4s ease;
            z-index: -1;
        }

        .btn-outline-light:hover::before {
            left: 0;
        }

        /* Efecto de aparición suave */
        .animate-nav {
            animation: fadeInDown 0.8s both;
        }

        /* Contenido principal */
        .main-content {
            flex: 1;
            padding: 2rem 0;
            background-color: rgba(244, 248, 253, 0.85);
        }

        /* Resto de estilos */
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            background-color: rgba(255, 255, 255, 0.95);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-danger {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .badge {
            font-weight: 500;
            padding: 0.5em 0.75em;
        }

        .wish-card {
            transition: var(--transition);
        }

        .wish-card:hover {
            background-color: rgba(248, 249, 250, 0.9);
        }

        .completed {
            opacity: 0.8;
            position: relative;
        }

        .completed::after {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: var(--secondary-color);
            transform: rotate(-5deg);
        }

        .floating-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            backdrop-filter: blur(4px);
            background-color: rgba(0, 0, 0, 0.8);
        }

        footer {
            background-color: rgba(0, 0, 0, 0.85) !important;
            backdrop-filter: blur(8px);
        }

        @media (max-width: 768px) {
            .floating-btn {
                bottom: 1rem;
                right: 1rem;
            }
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 animate-nav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <i class="fas fa-star me-2"></i>
                <span>Lista de Deseos</span>
            </a>
            <div class="d-flex align-items-center">
                @auth
                <span class="text-white me-3">Hola, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-light">
                        <i class="fas fa-sign-out-alt me-1"></i> Salir
                    </button>
                </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="main-content container py-4">
        @yield('content')
    </main>

    <footer class="mt-auto py-3 bg-dark text-white">
        <div class="container text-center">
            <small>© {{ date('Y') }} Lista de Deseos - Todos los derechos reservados</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Efecto de reducción al hacer scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Efecto de hover en el icono de la marca
        const brandIcon = document.querySelector('.navbar-brand i');
        brandIcon.addEventListener('mouseenter', function() {
            this.style.transform = 'rotate(15deg) scale(1.2)';
            this.style.textShadow = '0 0 10px rgba(244, 63, 94, 0.5)';
        });
        
        brandIcon.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.textShadow = '';
        });
    </script>
    @stack('scripts')
</body>
</html>