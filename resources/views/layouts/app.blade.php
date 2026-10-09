
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Sistema Transmetro')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    {{-- Iconos --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    {{-- Estilos propios --}}
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>

<body>

    {{-- Barra superior --}}
    <nav class="navbar navbar-expand-lg navbar-dark navbar-transmetro">
        <div class="container-fluid px-lg-4">

            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <i class="bi bi-bus-front-fill me-2"></i>
                TRANSMETRO
            </a>

            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuPrincipal"
                    aria-controls="menuPrincipal"
                    aria-expanded="false"
                    aria-label="Mostrar menú">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuPrincipal">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="bi bi-house-door me-1"></i> Inicio
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/municipios') }}">
                            Municipios
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/lineas') }}">
                            Líneas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/estaciones') }}">
                            Estaciones
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/accesos') }}">
                            Accesos
                        </a>
                    </li>

                </ul>
            </div>

        </div>
    </nav>

    {{-- Encabezado de página --}}
    <header class="page-header">
        <div class="container-fluid px-lg-4">
            <p class="page-subtitle mb-1">SISTEMA DE GESTIÓN DE TRANSPORTE</p>
            <h1 class="page-title mb-0">@yield('title', 'Panel de administración')</h1>
        </div>
    </header>

    {{-- Contenido de cada vista --}}
    <main class="container-fluid px-3 px-lg-4 py-4">
        @yield('content')
    </main>

    {{-- Pie de página --}}
    <footer class="footer-transmetro">
        <div class="container-fluid px-lg-4">
            Sistema de Gestión Transmetro
            <span class="mx-2">|</span>
            Proyecto académico
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
```
