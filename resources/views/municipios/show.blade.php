
@extends('layouts.app')

@section('title', 'Detalle del municipio')

@section('content')
    <h2>Detalle del municipio</h2>

    <p><strong>ID:</strong> {{ $municipio->id }}</p>
    <p><strong>Nombre:</strong> {{ $municipio->nombre }}</p>
    <p><strong>Departamento:</strong> {{ $municipio->departamento }}</p>

    <a href="{{ route('municipios.edit', $municipio) }}">Editar</a>
    |
    <a href="{{ route('municipios.index') }}">Volver a municipios</a>
@endsection
