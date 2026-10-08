@extends('layouts.app')

@section('title', 'Editar estación')

@section('content')

<div class="container">

    <h1>Editar estación</h1>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('estaciones.update', $estacion->id_estacion) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">
                Nombre de la estación:
            </label>

            <input type="text"
                   class="form-control"
                   id="nombre"
                   name="nombre"
                   value="{{ old('nombre', $estacion->nombre) }}"
                   required>
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">
                Dirección:
            </label>

            <input type="text"
                   class="form-control"
                   id="direccion"
                   name="direccion"
                   value="{{ old('direccion', $estacion->direccion) }}"
                   required>
        </div>

        <div class="mb-3">
            <label for="id_municipio" class="form-label">
                Municipio:
            </label>

            <select class="form-select"
                    id="id_municipio"
                    name="id_municipio"
                    required>

                <option value="">Seleccione un municipio</option>

                @foreach ($municipios as $municipio)
                    <option value="{{ $municipio->id_municipio }}"
                        {{ old('id_municipio', $estacion->id_municipio) == $municipio->id_municipio ? 'selected' : '' }}>
                        {{ $municipio->nombre }}
                    </option>
                @endforeach

            </select>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">
                Estado:
            </label>

            <select class="form-select"
                    id="estado"
                    name="estado"
                    required>

                <option value="1"
                    {{ old('estado', $estacion->estado) == 1 ? 'selected' : '' }}>
                    Activo
                </option>

                <option value="0"
                    {{ old('estado', $estacion->estado) == 0 ? 'selected' : '' }}>
                    Inactivo
                </option>

            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            Actualizar estación
        </button>

        <a href="{{ route('estaciones.index') }}"
           class="btn btn-secondary">
            Cancelar
        </a>

    </form>

</div>

@endsection
