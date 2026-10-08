@extends('layouts.app')

@section('title', 'Editar línea')

@section('content')

<h2>Editar línea</h2>

@if ($errors->any())
    <ul style="color: red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('lineas.update', $linea->id_linea) }}" method="POST">

    @csrf
    @method('PUT')

    <div>
        <label for="nombre">Nombre de la línea:</label>

        <input type="text"
               id="nombre"
               name="nombre"
               value="{{ old('nombre', $linea->nombre) }}"
               required>
    </div>

    <br>

    <div>
        <label for="distancia_total">Distancia total (km):</label>

        <input type="number"
               id="distancia_total"
               name="distancia_total"
               value="{{ old('distancia_total', $linea->distancia_total) }}"
               step="0.01"
               min="0"
               required>
    </div>

    <br>

    <div>
        <label for="id_municipio">Municipio:</label>

        <select id="id_municipio" name="id_municipio" required>

            <option value="">Seleccione un municipio</option>

            @foreach ($municipios as $municipio)

                <option value="{{ $municipio->id_municipio }}"
                    {{ old('id_municipio', $linea->id_municipio) == $municipio->id_municipio ? 'selected' : '' }}>

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
                {{ old('estado', $linea->estado) == 1 ? 'selected' : '' }}>
                Activo
            </option>

            <option value="0"
                {{ old('estado', $linea->estado) == 0 ? 'selected' : '' }}>
                Inactivo
            </option>

        </select>
    </div>

    <br>

    <button type="submit">Actualizar línea</button>

    <a href="{{ route('lineas.index') }}">Cancelar</a>

</form>

@endsection
