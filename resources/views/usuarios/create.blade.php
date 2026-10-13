
@extends('layouts.app')

@section('title', 'Registrar Usuario')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Registrar usuario</h2>
        <p class="text-muted">
            Ingrese la información del nuevo usuario.
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-person-plus me-2"></i>
            Datos del usuario
        </div>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('usuarios.store') }}"
                  method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="nombre" class="form-label">
                            Nombre completo *
                        </label>

                        <input type="text"
                               name="nombre"
                               id="nombre"
                               class="form-control @error('nombre') is-invalid @enderror"
                               value="{{ old('nombre') }}"
                               maxlength="100"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="correo" class="form-label">
                            Correo electrónico *
                        </label>

                        <input type="email"
                               name="correo"
                               id="correo"
                               class="form-control @error('correo') is-invalid @enderror"
                               value="{{ old('correo') }}"
                               maxlength="150"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">
                            Contraseña *
                        </label>

                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               minlength="3"
                               autocomplete="new-password"
                               required>

                        <small class="text-muted">
                            Mínimo 3 caracteres, incluyendo letras y números.
                        </small>
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">
                            Confirmar contraseña *
                        </label>

                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="form-control"
                               minlength="3"
                               autocomplete="new-password"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="rol" class="form-label">
                            Rol del usuario *
                        </label>

                        <select name="rol"
                                id="rol"
                                class="form-select @error('rol') is-invalid @enderror"
                                required>

                            <option value="">Seleccione un rol</option>

                            @foreach($roles as $rol)
                                <option value="{{ $rol }}"
                                    {{ old('rol') == $rol ? 'selected' : '' }}>
                                    {{ $rol }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="estado" class="form-label">
                            Estado *
                        </label>

                        <select name="estado"
                                id="estado"
                                class="form-select @error('estado') is-invalid @enderror"
                                required>

                            <option value="1"
                                {{ old('estado', '1') == '1' ? 'selected' : '' }}>
                                Activo
                            </option>

                            <option value="0"
                                {{ old('estado') === '0' ? 'selected' : '' }}>
                                Inactivo
                            </option>
                        </select>
                    </div>

                </div>

                <div class="alert alert-info mt-4">
                    <i class="bi bi-info-circle me-1"></i>
                    La contraseña se almacenará de forma protegida
                    mediante un hash.
                </div>

                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Guardar usuario
                    </button>

                    <a href="{{ route('usuarios.index') }}"
                       class="btn btn-secondary">
                        Cancelar
                    </a>

                </div>
            </form>
        </div>
    </div>

</div>
@endsection
