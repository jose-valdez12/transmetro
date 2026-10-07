@extends('layouts.app')

@section('title', 'Editar municipio')

@section('content')
<h2>Editar municipio</h2>

@if ($errors->any())
    <ul style="color: red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form action="{{ route('municipios.update', $municipios->id_municipio) }}" method="POST">

    @csrf
    @method('PUT')

    <div>
        <label for="nombre">Nombre del municipio:</label>

        <input type="text"
               id="nombre"
               name="nombre"
               value="{{ old('nombre', $municipios->nombre) }}"
               required>
    </div>

    <br>

    <div>
        <label for="departamento">Departamento:</label>

        <input type="text"
               id="departamento"
               name="departamento"
               value="{{ old('departamento', $municipios->departamento) }}"
               required>
    </div>

    <br>

    <div>
        <label for="estado">Estado:</label>

        <select id="estado" name="estado" required>
            <option value="1" {{ $municipios->estado ? 'selected' : '' }}>
                Activo
            </option>

            <option value="0" {{ !$municipios->estado ? 'selected' : '' }}>
                Inactivo
            </option>
        </select>
    </div>

    <br>

    <button type="submit">Actualizar municipio</button>

    <a href="{{ route('municipios.index') }}">Cancelar</a>

</form>

@endsection
