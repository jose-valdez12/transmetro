
@extends('layouts.app')

@section('title', 'Detalle del bus')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2 class="mb-1">Detalle del bus</h2>
        <p class="text-muted mb-0">
            Consulta la información del bus registrado en el sistema.
        </p>
    </div>

    {{-- Tarjeta de información --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-bus-front me-2"></i>
            Información del bus
        </div>

        <div class="card-body">

            <div class="row">

                {{-- ID --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold">
                        ID del bus
                    </label>

                    <div class="form-control bg-light">
                        {{ $bus->id_bus }}
                    </div>
                </div>

                {{-- Código --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold">
                        Código del bus
                    </label>

                    <div class="form-control bg-light">
                        {{ $bus->codigo }}
                    </div>
                </div>

                {{-- Capacidad máxima --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold">
                        Capacidad máxima
                    </label>

                    <div class="form-control bg-light">
                        {{ $bus->capacidad_maxima }} pasajeros
                    </div>
                </div>

                {{-- Estado --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold d-block">
                        Estado del bus
                    </label>

                    <div class="form-control bg-light">

                        @switch($bus->estado)

                            @case('Disponible')
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Disponible
                                </span>
                                @break

                            @case('Asignado')
                                <span class="badge bg-primary">
                                    <i class="bi bi-bus-front me-1"></i>
                                    Asignado
                                </span>
                                @break

                            @case('Mantenimiento')
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-tools me-1"></i>
                                    Mantenimiento
                                </span>
                                @break

                            @case('Fuera de servicio')
                                <span class="badge bg-danger">
                                    <i class="bi bi-x-circle me-1"></i>
                                    Fuera de servicio
                                </span>
                                @break

                            @default
                                <span class="badge bg-secondary">
                                    {{ $bus->estado }}
                                </span>

                        @endswitch

                    </div>
                </div>

            </div>

            <hr class="my-4">

            {{-- Botones --}}
            <div class="d-flex flex-wrap gap-2">

                <a href="{{ route('buses.edit', $bus->id_bus) }}"
                   class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i>
                    Editar bus
                </a>

                <a href="{{ route('buses.index') }}"
                   class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i>
                    Volver a buses
                </a>

            </div>

        </div>
    </div>

</div>
@endsection
