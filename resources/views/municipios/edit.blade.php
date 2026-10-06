
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

    <form action="{{ route('municipios.update', $municipio) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="nombre">Nombre del municipio:</label>
            <input type="text"
                   id="nombre"
                   name="nombre"
                   value="{{ old('nombre', $municipio->nombre) }}"
                   required>
        </div>

        <br>

        <div>
            <label for="departamento">Departamento:</label>
            <input type="text"
                   id="departamento"
                   name="departamento"
                   value="{{ old('departamento', $municipio->departamento) }}"
                   required>
        </div>

        <br>

        <button type="submit">Actualizar municipio</button>
        <a href="{{ route('municipios.index') }}">Cancelar</a>
    </form>
@endsection
