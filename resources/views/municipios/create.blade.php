@extends('layouts.app')

@section('title', 'Registrar municipio')

@section('content')
    <h2>Registrar municipio</h2>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('municipios.store') }}" method="POST">
        @csrf

       <div>
    <label for="nombre">Nombre del municipio:</label>
    <input type="text"
           id="nombre"
           name="nombre"
           value="{{ old('nombre') }}"
           required>
</div>

<br>

<div>
    <label for="departamento">Departamento:</label>
    <input type="text"
           id="departamento"
           name="departamento"
           value="{{ old('departamento') }}"
           required>
</div>

<br>

<div>
    <label for="estado">Estado:</label>
    <select id="estado" name="estado" required>
        <option value="1">Activo</option>
        <option value="0">Inactivo</option>
    </select>
</div>

        <br>

        <button type="submit">Guardar municipio</button>
        <a href="{{ route('municipios.index') }}">Cancelar</a>
    </form>
@endsection
