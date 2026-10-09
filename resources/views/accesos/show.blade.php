
@extends('layouts.app')

@section('title', 'Detalle del Acceso')

@section('content')

<div class="container mt-4">

    <h1>Detalle del Acceso</h1>

    <div class="card shadow-sm">
        <div class="card-header">
            Información del acceso
        </div>

        <div class="card-body">

            <p>
                <strong>ID:</strong>
                {{ $acceso->id_acceso }}
            </p>

            <p>
                <strong>Nombre:</strong>
                {{ $acceso->nombre }}
            </p>

            <p>
                <strong>Estación:</strong>
                {{ $acceso->estacion->nombre ?? 'Sin estación asignada' }}
            </p>

            <p>
                <strong>Dirección de la estación:</strong>
                {{ $acceso->estacion->direccion ?? 'No disponible' }}
            </p>

            <p>
                <strong>Municipio:</strong>
                {{ $acceso->estacion->municipio->nombre ?? 'Sin municipio' }}
            </p>

            <p>
                <strong>Estado:</strong>

                @if ($acceso->estado)
                    <span class="badge bg-success">Activo</span>
                @else
                    <span class="badge bg-danger">Inactivo</span>
                @endif
            </p>

            <a href="{{ route('accesos.edit', $acceso->id_acceso) }}"
               class="btn btn-warning">
                Editar
            </a>

            <a href="{{ route('accesos.index') }}"
               class="btn btn-secondary">
                Regresar a Accesos
            </a>

        </div>
    </div>

</div>

@endsection
