
@extends('layouts.app')

@section('title', 'Detalle del municipio')

@section('content')
    <h2>Detalle del municipio</h2>

    <p><strong>ID:</strong> {{ $municipios->id }}</p>
    <p><strong>Nombre:</strong> {{ $municipios->nombre }}</p>
    <p><strong>Estado:</strong> {{ $municipios->estado }}</p>
    <p><strong>Departamento:</strong> {{ $municipios->departamento }}</p>

    <a href="{{ route('municipios.edit', $municipios) }}">Editar</a>
    |
    <a href="{{ route('municipios.index') }}">Volver a municipios</a>
@endsection
