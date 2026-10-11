
@extends('layouts.app')

@section('title', 'Detalle de visita')

@section('content')
<div class="container-fluid">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Detalle de visita a estación</h2>
            <p class="text-muted mb-0">
                Información del recorrido y la visita registrada.
            </p>
        </div>

        <a href="{{ route('visitas.index') }}"
           class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Volver
        </a>
    </div>

    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-info-circle me-2"></i>
            Visita #{{ $visita->id_visita }}
        </div>

        <div class="card-body">

            <h5 class="mb-3">Información del recorrido</h5>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        Número de recorrido
                    </label>
                    <div class="form-control bg-light">
                        #{{ $visita->id_recorrido }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        Código del bus
                    </label>
                    <div class="form-control bg-light">
                        {{ $visita->recorrido->bus->codigo ?? 'No disponible' }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        Línea de transporte
                    </label>
                    <div class="form-control bg-light">
                        {{ $visita->recorrido->linea->nombre ?? 'No disponible' }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        Estación visitada
                    </label>
                    <div class="form-control bg-light">
                        {{ $visita->estacion->nombre ?? 'No disponible' }}
                    </div>
                </div>

            </div>

            <hr>

            <h5 class="mb-3">Registro de la visita</h5>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        Fecha y hora de llegada
                    </label>
                    <div class="form-control bg-light">
                        {{ $visita->fecha_hora_llegada
                            ? $visita->fecha_hora_llegada->format('d/m/Y H:i')
                            : 'Sin registrar' }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        Fecha y hora de salida
                    </label>
                    <div class="form-control bg-light">
                        {{ $visita->fecha_hora_salida
                            ? $visita->fecha_hora_salida->format('d/m/Y H:i')
                            : 'El bus permanece en la estación' }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        Cantidad de pasajeros
                    </label>
                    <div class="form-control bg-light">
                        {{ $visita->cantidad_pasajeros }} pasajeros
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        Capacidad máxima del bus
                    </label>
                    <div class="form-control bg-light">
                        {{ $visita->recorrido->bus->capacidad_maxima ?? 'No disponible' }}
                    </div>
                </div>

            </div>

            {{-- Ocupación del bus --}}
            @if (
                $visita->recorrido &&
                $visita->recorrido->bus &&
                $visita->recorrido->bus->capacidad_maxima > 0
            )

                @php
                    $capacidad = $visita->recorrido->bus->capacidad_maxima;
                    $ocupacion = ($visita->cantidad_pasajeros / $capacidad) * 100;
                @endphp

                <hr>

                <h5 class="mb-3">Nivel de ocupación del bus</h5>

                <p>
                    <strong>Porcentaje de ocupación:</strong>
                    {{ number_format($ocupacion, 2) }}%
                </p>

                <div class="progress mb-3" style="height: 25px;">

                    <div class="progress-bar {{ $ocupacion < 25 ? 'bg-warning text-dark' : 'bg-success' }}"
                         role="progressbar"
                         style="width: {{ min($ocupacion, 100) }}%;"
                         aria-valuenow="{{ $ocupacion }}"
                         aria-valuemin="0"
                         aria-valuemax="100">

                        {{ number_format($ocupacion, 2) }}%

                    </div>

                </div>

                @if ($ocupacion < 25)

                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Ocupación baja:</strong>
                        el bus transporta menos del 25% de su capacidad.
                        Según la regla del sistema, corresponde una espera
                        adicional de 5 minutos en la estación.
                    </div>

                @else

                    <div class="alert alert-success">
                        <i class="bi bi-check-circle me-2"></i>
                        El bus tiene una ocupación igual o superior al 25%
                        de su capacidad.
                    </div>

                @endif

            @endif

            <hr>

            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('visitas.index') }}"
                   class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Regresar
                </a>

                <a href="{{ route('visitas.edit', $visita->id_visita) }}"
                   class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i>
                    Editar visita
                </a>

            </div>

        </div>
    </div>

</div>
@endsection
