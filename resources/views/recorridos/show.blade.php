
@extends('layouts.app')

@section('title', 'Detalle del recorrido')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Detalle del recorrido</h2>
        <p class="text-muted">
            Información del recorrido realizado por el bus.
        </p>
    </div>

    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-info-circle me-2"></i>
            Información del recorrido #{{ $recorrido->id_recorrido }}
        </div>

        <div class="card-body">

            <div class="row">

                {{-- Identificador --}}
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">ID del recorrido</label>
                    <p>{{ $recorrido->id_recorrido }}</p>
                </div>

                {{-- Código del bus --}}
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Código del bus</label>
                    <p>{{ $recorrido->bus->codigo ?? 'Sin bus' }}</p>
                </div>

                {{-- Capacidad del bus --}}
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Capacidad máxima del bus</label>
                    <p>
                        {{ $recorrido->bus->capacidad_maxima ?? 0 }}
                        pasajeros
                    </p>
                </div>

                {{-- Línea --}}
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Línea de transporte</label>
                    <p>{{ $recorrido->linea->nombre ?? 'Sin línea' }}</p>
                </div>

                {{-- Fecha --}}
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Fecha del recorrido</label>
                    <p>
                        {{ $recorrido->fecha
                            ? $recorrido->fecha->format('d/m/Y')
                            : 'No registrada' }}
                    </p>
                </div>

                {{-- Hora de inicio --}}
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Hora de inicio</label>
                    <p>
                        {{ $recorrido->hora_inicio
                            ? substr($recorrido->hora_inicio, 0, 5)
                            : 'Sin iniciar' }}
                    </p>
                </div>

                {{-- Hora de finalización --}}
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Hora de finalización</label>
                    <p>
                        {{ $recorrido->hora_fin
                            ? substr($recorrido->hora_fin, 0, 5)
                            : 'Sin finalizar' }}
                    </p>
                </div>

                {{-- Estado --}}
                <div class="col-md-6 mb-3">
                    <label class="fw-bold">Estado del recorrido</label>
                    <p>
                        @if ($recorrido->estado == 'Programado')
                            <span class="badge bg-primary">Programado</span>

                        @elseif ($recorrido->estado == 'En curso')
                            <span class="badge bg-warning text-dark">En curso</span>

                        @elseif ($recorrido->estado == 'Finalizado')
                            <span class="badge bg-success">Finalizado</span>

                        @elseif ($recorrido->estado == 'Cancelado')
                            <span class="badge bg-danger">Cancelado</span>

                        @else
                            <span class="badge bg-secondary">Desconocido</span>
                        @endif
                    </p>
                </div>

            </div>

            <hr>

            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('recorridos.index') }}"
                   class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver
                </a>

                <a href="{{ route('recorridos.edit', $recorrido->id_recorrido) }}"
                   class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i>
                    Editar recorrido
                </a>

            </div>

        </div>
    </div>

</div>
@endsection
