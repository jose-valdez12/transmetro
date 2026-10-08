@extends('layouts.app')

@section('title', 'Ver estación')

@section('content')

<div class="container">

    <h1>Detalles de la estación</h1>

    <div class="mb-3">
        <label class="form-label">ID de la estación</label>

        <input type="text"
               class="form-control"
               value="{{ $estacion->id_estacion }}"
               readonly>
    </div>

    <div class="mb-3">
        <label class="form-label">Nombre</label>

        <input type="text"
               class="form-control"
               value="{{ $estacion->nombre }}"
               readonly>
    </div>

    <div class="mb-3">
        <label class="form-label">Dirección</label>

        <input type="text"
               class="form-control"
               value="{{ $estacion->direccion }}"
               readonly>
    </div>

    <div class="mb-3">
        <label class="form-label">Municipio</label>

        <input type="text"
               class="form-control"
               value="{{ $estacion->municipio->nombre ?? 'Sin municipio' }}"
               readonly>
    </div>

    <div class="mb-3">
        <label class="form-label">Estado</label>

        <input type="text"
               class="form-control"
               value="{{ $estacion->estado ? 'Activo' : 'Inactivo' }}"
               readonly>
    </div>

    <a href="{{ route('estaciones.edit', $estacion->id_estacion) }}"
       class="btn btn-warning">
        Editar
    </a>

    <a href="{{ route('estaciones.index') }}"
       class="btn btn-secondary">
        Volver
    </a>

</div>

@endsection
