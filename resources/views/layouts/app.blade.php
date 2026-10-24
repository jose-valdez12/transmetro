
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Sistema Transmetro')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>

<body>

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-xl navbar-dark navbar-transmetro shadow-sm">
        <div class="container-fluid px-lg-4">

            <!-- Logo -->
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2">

                <i class="bi bi-bus-front-fill fs-4"></i>
                TRANSMETRO
            </a>

            <!-- Botón responsive -->
            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#menuPrincipal"
                    aria-controls="menuPrincipal"
                    aria-expanded="false"
                    aria-label="Mostrar menú">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuPrincipal">

                <!-- Menú principal -->
                <ul class="navbar-nav me-auto mb-2 mb-xl-0">

                    <!-- Inicio -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="bi bi-house-door me-1"></i>
                            Inicio
                        </a>
                    </li>

                    <!-- Infraestructura -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#"
                           role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="bi bi-buildings me-1"></i>
                            Infraestructura
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ url('/municipios') }}">
                                    <i class="bi bi-geo-alt me-2"></i>
                                    Municipalidades
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ url('/lineas') }}">
                                    <i class="bi bi-diagram-3 me-2"></i>
                                    Líneas
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ url('/estaciones') }}">
                                    <i class="bi bi-signpost me-2"></i>
                                    Estaciones
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ url('/accesos') }}">
                                    <i class="bi bi-door-open me-2"></i>
                                    Accesos
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('parqueos.index') }}">
                                    <i class="bi bi-p-square me-2"></i>
                                    Parqueos
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Operaciones -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#"
                           role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="bi bi-bus-front me-1"></i>
                            Operaciones
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ url('/buses') }}">
                                    <i class="bi bi-bus-front me-2"></i>
                                    Buses
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ url('/recorridos') }}">
                                    <i class="bi bi-map me-2"></i>
                                    Recorridos
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ url('/alertas') }}">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Alertas
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Personal -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#"
                           role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="bi bi-people me-1"></i>
                            Personal
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ url('/pilotos') }}">
                                    <i class="bi bi-person-badge me-2"></i>
                                    Pilotos
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('guardias.index') }}">
                                    <i class="bi bi-shield-check me-2"></i>
                                    Guardias
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Administración -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#"
                           role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="bi bi-gear me-1"></i>
                            Administración
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('usuarios.index') }}">
                                    <i class="bi bi-people me-2"></i>
                                    Gestión de Usuarios
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('reportes.index') }}">
                                    <i class="bi bi-file-earmark-bar-graph me-2"></i>
                                    Gestión de Reportes
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>

                <!-- Usuario y sesión -->
                <div class="d-flex flex-column flex-xl-row align-items-xl-center gap-3 mt-3 mt-xl-0">

                    @guest
                        <a href="{{ route('login') }}"
                           class="btn btn-success btn-sm px-3">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            Iniciar sesión
                        </a>
                    @endguest

                    @auth
                        <div class="usuario-navbar d-flex align-items-center gap-2">
                            <i class="bi bi-person-circle fs-4"></i>

                            <div class="d-flex flex-column lh-sm">
                                <small>Usuario conectado</small>
                                <strong>{{ auth()->user()->nombre }}</strong>
                            </div>
                        </div>

                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf

                            <button type="submit"
                                    class="btn btn-outline-light btn-sm px-3">
                                <i class="bi bi-box-arrow-right me-1"></i>
                                Cerrar sesión
                            </button>
                        </form>
                    @endauth

                </div>

            </div>
        </div>
    </nav>

    <!-- Encabezado -->
    <header class="page-header">
        <div class="container-fluid px-lg-4">
            <p class="page-subtitle mb-1">
                SISTEMA DE GESTIÓN DE TRANSPORTE
            </p>

            <h1 class="page-title mb-0">
                @yield('title', 'Panel de administración')
            </h1>
        </div>
    </header>

    <!-- Contenido -->
    <main class="container-fluid px-3 px-lg-4 py-4">
        @yield('content')
    </main>

    <!-- Pie de página -->
    <footer class="footer-transmetro">
        <div class="container-fluid px-lg-4">
            Sistema de Gestión Transmetro
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
