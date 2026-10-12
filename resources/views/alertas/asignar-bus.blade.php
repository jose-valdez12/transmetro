
@extends('layouts.app')

@section('title', 'Asignar Bus Adicional')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            <i class="bi bi-bus-front-fill"></i>
            Asignar Bus Adicional
        </h3>

        <a href="{{ route('alertas.index') }}"
           class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Corrige los siguientes errores:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">

        <!-- Información de la alerta -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 h-100">

                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-exclamation-triangle"></i>
                        Alerta de alta demanda
                    </h5>
                </div>

                <div class="card-body">

                    <p>
                        <strong>Código:</strong>
                        {{ $alerta->id_alerta }}
                    </p>

                    <p>
                        <strong>Estación:</strong>
                        {{ $alerta->estacion->nombre ?? 'Sin estación' }}
                    </p>

                    <p>
                        <strong>Tipo:</strong>
                        {{ $alerta->tipo }}
                    </p>

                    <p>
                        <strong>Estado:</strong>
                        <span class="badge bg-warning text-dark">
                            {{ $alerta->estado }}
                        </span>
                    </p>

                    <hr>

                    <p class="mb-0">
                        {{ $alerta->descripcion }}
                    </p>

                </div>
            </div>
        </div>

        <!-- Formulario de asignación -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 h-100">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-bus-front"></i>
                        Datos del bus adicional
                    </h5>
                </div>

                <div class="card-body">

                    <form
                        action="{{ route('alertas.guardar-asignacion', $alerta->id_alerta) }}"
                        method="POST">

                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Línea de transporte
                            </label>

                            <select name="id_linea"
                                    class="form-select"
                                    required>

                                <option value="">
                                    Seleccione una línea
                                </option>

                                @foreach($lineas as $linea)
                                    <option
                                        value="{{ $linea->id_linea }}"
                                        {{ old('id_linea') == $linea->id_linea ? 'selected' : '' }}>
                                        {{ $linea->nombre }}
                                    </option>
                                @endforeach

                            </select>

                            <small class="text-muted">
                                Solo aparecen las líneas que pasan por la estación.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Bus disponible
                            </label>

                            <select name="id_bus"
                                    class="form-select"
                                    required>

                                <option value="">
                                    Seleccione un bus
                                </option>

                                @foreach($buses as $bus)
                                    <option
                                        value="{{ $bus->id_bus }}"
                                        {{ old('id_bus') == $bus->id_bus ? 'selected' : '' }}>
                                        {{ $bus->codigo }}
                                        - Capacidad: {{ $bus->capacidad_maxima }}
                                        pasajeros
                                    </option>
                                @endforeach

                            </select>

                            <small class="text-muted">
                                Solo aparecen buses con estado Disponible.
                            </small>
                        </div>

                        @if($lineas->isEmpty() || $buses->isEmpty())
                            <div class="alert alert-warning">
                                No hay líneas asociadas a esta estación
                                o no existen buses disponibles para
                                realizar la asignación.
                            </div>
                        @endif

                        <div class="d-flex gap-2 mt-4">

                            <button type="submit"
                                    class="btn btn-primary"
                                    {{ $lineas->isEmpty() || $buses->isEmpty() ? 'disabled' : '' }}>
                                <i class="bi bi-check-circle"></i>
                                Confirmar asignación
                            </button>

                            <a href="{{ route('alertas.index') }}"
                               class="btn btn-outline-secondary">
                                Cancelar
                            </a>

                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
