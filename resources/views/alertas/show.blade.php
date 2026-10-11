
@extends('layouts.app')

@section('title', 'Detalle de Alerta')

@section('content')
<div class="container-fluid">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Detalle de Alerta</h2>
            <p class="text-muted mb-0">
                Información completa de la alerta registrada.
            </p>
        </div>

        <a href="{{ route('alertas.index') }}"
           class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Volver
        </a>
    </div>

    {{-- Información de la alerta --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Alerta #{{ $alerta->id_alerta }}
        </div>

        <div class="card-body">

            <h5 class="mb-3">Información general</h5>

            <div class="row">

                {{-- ID --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        Número de alerta
                    </label>

                    <div class="form-control bg-light">
                        #{{ $alerta->id_alerta }}
                    </div>
                </div>

                {{-- Tipo --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        Tipo de alerta
                    </label>

                    <div class="form-control bg-light">
                        {{ $alerta->tipo }}
                    </div>
                </div>

                {{-- Recorrido --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        Recorrido relacionado
                    </label>

                    <div class="form-control bg-light">
                        @if ($alerta->recorrido)
                            Recorrido #{{ $alerta->recorrido->id_recorrido }}
                        @else
                            No asignado
                        @endif
                    </div>
                </div>

                {{-- Estación --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        Estación relacionada
                    </label>

                    <div class="form-control bg-light">
                        {{ $alerta->estacion->nombre ?? 'No asignada' }}
                    </div>
                </div>

                {{-- Fecha y hora --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        Fecha y hora
                    </label>

                    <div class="form-control bg-light">
                        {{ $alerta->fecha_hora
                            ? $alerta->fecha_hora->format('d/m/Y H:i')
                            : 'Sin registrar' }}
                    </div>
                </div>

                {{-- Estado --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">
                        Estado de la alerta
                    </label>

                    <div class="mt-2">
                        @if ($alerta->estado == 'Pendiente')
                            <span class="badge bg-warning text-dark fs-6">
                                <i class="bi bi-clock me-1"></i>
                                Pendiente
                            </span>
                        @elseif ($alerta->estado == 'Atendida')
                            <span class="badge bg-success fs-6">
                                <i class="bi bi-check-circle me-1"></i>
                                Atendida
                            </span>
                        @else
                            <span class="badge bg-secondary fs-6">
                                {{ $alerta->estado }}
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <hr>

            <h5 class="mb-3">Descripción de la alerta</h5>

            <div class="border rounded bg-light p-3 mb-4"
                 style="white-space: pre-wrap;">{{ $alerta->descripcion }}</div>

            {{-- Mensaje según el estado --}}
            @if ($alerta->estado == 'Pendiente')

                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    Esta alerta se encuentra pendiente de atención.
                </div>

            @elseif ($alerta->estado == 'Atendida')

                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>
                    Esta alerta ha sido marcada como atendida.
                </div>

            @endif

            <hr>

            {{-- Botones --}}
            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('alertas.index') }}"
                   class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Regresar
                </a>

                <a href="{{ route('alertas.edit', $alerta->id_alerta) }}"
                   class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i>
                    Editar alerta
                </a>

            </div>

        </div>
    </div>

</div>
@endsection
