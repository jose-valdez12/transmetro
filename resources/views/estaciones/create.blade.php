@extends('layouts.app')

@section('title', 'Registrar estación')

@section('content')

<div class="container">

    <h1>Registrar estación</h1>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('estaciones.store') }}" method="POST">

        @csrf

        <div>
            <label for="nombre">Nombre de la estación:</label>

            <input type="text"
                   id="nombre"
                   name="nombre"
                   value="{{ old('nombre') }}"
                   required>
        </div>

        <br>

        <div>
            <label for="direccion">Dirección:</label>

            <input type="text"
                   id="direccion"
                   name="direccion"
                   value="{{ old('direccion') }}"
                   required>
        </div>

        <br>

        <div>
            <label for="id_municipio">Municipio:</label>

            <select id="id_municipio" name="id_municipio" required>

                <option value="">Seleccione un municipio</option>

                @foreach ($municipios as $municipio)

                    <option value="{{ $municipio->id_municipio }}"
                        {{ old('id_municipio') == $municipio->id_municipio ? 'selected' : '' }}>

                        {{ $municipio->nombre }}

                    </option>

                @endforeach

            </select>
        </div>

        <br>

        <div>
            <label for="estado">Estado:</label>

            <select id="estado" name="estado" required>

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

        <br>

        <button type="submit">
            Guardar estación
        </button>

        <a href="{{ route('estaciones.index') }}">
            Cancelar
        </a>

    </form>

</div>

@endsection
