@extends('layouts.app')

@section('title', 'Ver línea')

@section('content')

<h2>Ver línea</h2>

<div>
    <p>
        <strong>ID:</strong>
        {{ $linea->id_linea }}
    </p>

    <p>
        <strong>Nombre:</strong>
        {{ $linea->nombre }}
    </p>

    <p>
        <strong>Distancia total:</strong>
        {{ $linea->distancia_total }} km
    </p>

    <p>
        <strong>Municipio:</strong>
        {{ $linea->municipio->nombre ?? 'Sin municipio' }}
    </p>

    <p>
        <strong>Estado:</strong>
        {{ $linea->estado ? 'Activo' : 'Inactivo' }}
    </p>
</div>

<br>

<a href="{{ route('lineas.edit', $linea->id_linea) }}">
    Editar
</a>

&nbsp;

<a href="{{ route('lineas.index') }}">
    Volver
</a>

@endsection
