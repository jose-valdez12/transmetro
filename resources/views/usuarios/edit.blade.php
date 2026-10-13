
@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Editar usuario</h2>
        <p class="text-muted">
            Actualice la información del usuario seleccionado.
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-pencil-square me-2"></i>
            Editar usuario #{{ $usuario->id_usuario }}
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

            <form action="{{ route('usuarios.update', $usuario->id_usuario) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="nombre" class="form-label">
                            Nombre completo *
                        </label>

                        <input type="text"
                               name="nombre"
                               id="nombre"
                               class="form-control @error('nombre') is-invalid @enderror"
                               value="{{ old('nombre', $usuario->nombre) }}"
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
                               value="{{ old('correo', $usuario->correo) }}"
                               maxlength="150"
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

                            @foreach($roles as $rol)
                                <option value="{{ $rol }}"
                                    {{ old('rol', $usuario->rol) == $rol ? 'selected' : '' }}>
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
                                {{ old('estado', (string)(int)$usuario->estado) == '1' ? 'selected' : '' }}>
                                Activo
                            </option>

                            <option value="0"
                                {{ old('estado', (string)(int)$usuario->estado) == '0' ? 'selected' : '' }}>
                                Inactivo
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">
                            Nueva contraseña
                        </label>

                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               minlength="8"
                               autocomplete="new-password">

                        <small class="text-muted">
                            Déjelo vacío si no desea cambiar la contraseña.
                        </small>
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">
                            Confirmar nueva contraseña
                        </label>

                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="form-control"
                               minlength="8"
                               autocomplete="new-password">
                    </div>

                </div>

                <div class="alert alert-info mt-4">
                    <i class="bi bi-shield-lock me-1"></i>
                    Por seguridad, la contraseña actual no se muestra.
                    Solo se actualizará si ingresa una nueva.
                </div>

                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Guardar cambios
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
