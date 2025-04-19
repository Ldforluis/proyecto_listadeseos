<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        .footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 15px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">Lista De Deseos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Deseos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Categorías</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Estados</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido dinámico -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer">
        &copy; {{ date('Y') }} Mi Aplicación. Todos los derechos reservados.
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

