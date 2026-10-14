
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
                    <li clas="nav-item">
                        <!-- BOTONES DE AUTENTICACIÓN -->
<div class="d-flex align-items-center gap-2">

    @guest
        <a href="{{ route('login') }}"
           class="btn btn-primary">
            <i class="bi bi-box-arrow-in-right me-1"></i>
            Iniciar sesión
        </a>
    @endguest

    @auth
        <span class="text-muted me-2">
            <i class="bi bi-person-circle me-1"></i>
            {{ auth()->user()->nombre }}
        </span>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit"
                    class="btn btn-outline-danger">
                <i class="bi bi-box-arrow-right me-1"></i>
                Cerrar sesión
            </button>
        </form>
    @endauth

</div>

</li>


                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/municipios') }}">
                            Municipalidades
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

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/buses') }}">
                            Buses
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/recorridos') }}">
                            Recorridos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/alertas') }}">
                            Alertas
                        </a>
                    </li>

                    <li class="navitem">
                    <a class="nav-link" href="{{url('/pilotos')}}">
                        Pilotos
                    </a>
                    </li>

                    <li class="navitem">
                        <a class ="nav-link" href="{{ route('guardias.index')}}">
                            Guardias
                        </a>
                    </li>

<li class="navitem">
    <a class=" nav-link" href="{{ route('parqueos.index') }}" class="nav-link">
    <i class="bi bi-p-square me-2"></i>
    Gestión de Parqueos
</a>
</li>

<li class="navitem">
    <a href="{{ route('usuarios.index') }}" class="nav-link">
    <i class="bi bi-people me-2"></i>
    Gestión de Usuarios
</a>
</li>

<li class="navitem">
<a href="{{ route('reportes.index') }}" class="nav-link">
    <i class="bi bi-file-earmark-bar-graph me-2"></i>
    Gestión de Reportes
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

        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

