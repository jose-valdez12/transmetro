
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar Sesión | Transmetro</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a, #1e3a8a);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            padding: 15px;
        }

        .login-card {
            background: #ffffff;
            border: none;
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
        }

        .logo {
            width: 80px;
            height: 80px;
            background: #2563eb;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            margin: 0 auto 20px;
        }

        .titulo {
            font-weight: bold;
            color: #0f172a;
        }

        .subtitulo {
            color: #64748b;
            font-size: 14px;
        }

        .form-control {
            padding: 12px;
        }

        .input-group-text {
            background: #f8fafc;
        }

        .btn-login {
            background: #2563eb;
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
        }

        .btn-login:hover {
            background: #1d4ed8;
        }

        .footer-login {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 25px;
        }
    </style>
</head>

<body>

<div class="login-container">

    <div class="login-card">

        <!-- Encabezado -->
        <div class="text-center mb-4">

            <div class="logo">
                <i class="bi bi-bus-front-fill"></i>
            </div>

            <h2 class="titulo">TRANSMETRO</h2>

            <p class="subtitulo">
                Sistema de Gestión de Transporte
            </p>

            <h5 class="mt-4">
                Inicio de Sesión
            </h5>

            <p class="text-muted small">
                Ingrese sus credenciales para acceder al sistema.
            </p>

        </div>

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Errores de validación -->
        @if($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>

                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Formulario -->
        <form action="{{ route('login.procesar') }}" method="POST">

            @csrf

            <!-- Correo -->
            <div class="mb-3">

                <label for="correo" class="form-label fw-semibold">
                    Correo electrónico
                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>

                    <input
                        type="email"
                        name="correo"
                        id="correo"
                        class="form-control"
                        placeholder="Ingrese su correo"
                        value="{{ old('correo') }}"
                        autocomplete="username"
                        required
                        autofocus
                    >

                </div>

            </div>

            <!-- Contraseña -->
            <div class="mb-3">

                <label for="password" class="form-label fw-semibold">
                    Contraseña
                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="Ingrese su contraseña"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        class="btn btn-outline-secondary"
                        type="button"
                        id="mostrarPassword"
                        aria-label="Mostrar contraseña"
                    >
                        <i class="bi bi-eye" id="iconoPassword"></i>
                    </button>

                </div>

            </div>

            <!-- Botón de acceso -->
            <div class="d-grid mt-4">

                <button type="submit" class="btn btn-primary btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Iniciar Sesión
                </button>

            </div>

        </form>

        <!-- Pie -->
        <div class="text-center footer-login">
            <i class="bi bi-shield-lock me-1"></i>
            Acceso exclusivo para personal autorizado
        </div>

    </div>

    <p class="text-center text-white-50 mt-3 small">
        Sistema de Gestión Transmetro
    </p>

</div>

<!-- JavaScript -->
<script>
    const boton = document.getElementById('mostrarPassword');
    const password = document.getElementById('password');
    const icono = document.getElementById('iconoPassword');

    boton.addEventListener('click', function () {

        if (password.type === 'password') {
            password.type = 'text';
            icono.classList.remove('bi-eye');
            icono.classList.add('bi-eye-slash');
        } else {
            password.type = 'password';
            icono.classList.remove('bi-eye-slash');
            icono.classList.add('bi-eye');
        }

    });
</script>

</body>
</html>
