
@extends('layouts.app')

@section('title', 'Detalle de asignación')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Detalle de asignación de bus</h2>
        <p class="text-muted">
            Información del bus y la línea de transporte asignada.
        </p>
    </div>

    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-info-circle me-2"></i>
            Información de la asignación
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">ID de asignación</label>
                    <p>{{ $asignacion->id_asignacion }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Código del bus</label>
                    <p>{{ $asignacion->bus->codigo ?? 'Sin bus' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Capacidad máxima</label>
                    <p>
                        {{ $asignacion->bus->capacidad_maxima ?? 0 }}
                        pasajeros
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Línea de transporte</label>
                    <p>{{ $asignacion->linea->nombre ?? 'Sin línea' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Fecha de inicio</label>
                    <p>
                        {{ $asignacion->fecha_inicio
                            ? $asignacion->fecha_inicio->format('d/m/Y')
                            : '-' }}
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Fecha de finalización</label>
                    <p>
                        {{ $asignacion->fecha_fin
                            ? $asignacion->fecha_fin->format('d/m/Y')
                            : 'Sin fecha definida' }}
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Estado de la asignación</label>
                    <p>
                        @if ($asignacion->estado)
                            <span class="badge bg-success">Activa</span>
                        @else
                            <span class="badge bg-danger">Inactiva</span>
                        @endif
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Estado del bus</label>
                    <p>
                        {{ $asignacion->bus->estado ?? 'No disponible' }}
                    </p>
                </div>

            </div>

            <hr>

            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('asignacion-bus.index') }}"
                   class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>

                <a href="{{ route('asignacion-bus.edit', $asignacion->id_asignacion) }}"
                   class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i>
                    Editar asignación
                </a>

            </div>

        </div>
    </div>

</div>
@endsection
