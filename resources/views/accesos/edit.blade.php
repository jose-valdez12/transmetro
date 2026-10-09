
@extends('layouts.app')

@section('title', 'Editar Acceso')

@section('content')

<div class="container mt-4">

    <h1>Editar Acceso</h1>

    <div class="card shadow-sm">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('accesos.update', $acceso->id_acceso) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">ID del acceso</label>

                    <input type="text"
                           class="form-control"
                           value="{{ $acceso->id_acceso }}"
                           disabled>
                </div>

                <div class="mb-3">
                    <label for="nombre" class="form-label">
                        Nombre del acceso
                    </label>

                    <input type="text"
                           name="nombre"
                           id="nombre"
                           class="form-control"
                           value="{{ old('nombre', $acceso->nombre) }}"
                           maxlength="100"
                           required>
                </div>

                <div class="mb-3">
                    <label for="id_estacion" class="form-label">
                        Estación
                    </label>

                    <select name="id_estacion"
                            id="id_estacion"
                            class="form-select"
                            required>

                        <option value="">Seleccione una estación</option>

                        @foreach ($estaciones as $estacion)
                            <option value="{{ $estacion->id_estacion }}"
                                {{ old('id_estacion', $acceso->id_estacion) == $estacion->id_estacion ? 'selected' : '' }}>
                                {{ $estacion->nombre }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label">
                        Estado
                    </label>

                    <select name="estado" id="estado" class="form-select" required>
                        <option value="1"
                            {{ old('estado', (string) (int) $acceso->estado) === '1' ? 'selected' : '' }}>
                            Activo
                        </option>

                        <option value="0"
                            {{ old('estado', (string) (int) $acceso->estado) === '0' ? 'selected' : '' }}>
                            Inactivo
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Guardar Cambios
                </button>

                <a href="{{ route('accesos.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>

            </form>

        </div>
    </div>

</div>

@endsection

