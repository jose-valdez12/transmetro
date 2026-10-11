
@extends('layouts.app')

@section('title', 'Nuevo recorrido')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Registrar nuevo recorrido</h2>
        <p class="text-muted">
            Ingrese los datos del recorrido que realizará el bus.
        </p>
    </div>

    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-sign-turn-right me-2"></i>
            Registro de recorrido
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>No se pudo guardar el recorrido.</strong>
                    Revise los datos ingresados.
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('recorridos.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Seleccionar bus --}}
                    <div class="col-md-6 mb-3">
                        <label for="id_bus" class="form-label">
                            Bus asignado
                        </label>

                        <select name="id_bus"
                                id="id_bus"
                                class="form-select @error('id_bus') is-invalid @enderror"
                                required>

                            <option value="">Seleccione un bus</option>

                            @foreach ($buses as $bus)
                                <option value="{{ $bus->id_bus }}"
                                    {{ old('id_bus') == $bus->id_bus ? 'selected' : '' }}>
                                    {{ $bus->codigo }}
                                    - Capacidad: {{ $bus->capacidad_maxima }} pasajeros
                                </option>
                            @endforeach

                        </select>

                        @error('id_bus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Seleccionar línea --}}
                    <div class="col-md-6 mb-3">
                        <label for="id_linea" class="form-label">
                            Línea de transporte
                        </label>

                        <select name="id_linea"
                                id="id_linea"
                                class="form-select @error('id_linea') is-invalid @enderror"
                                required>

                            <option value="">Seleccione una línea</option>

                            @foreach ($lineas as $linea)
                                <option value="{{ $linea->id_linea }}"
                                    {{ old('id_linea') == $linea->id_linea ? 'selected' : '' }}>
                                    {{ $linea->nombre }}
                                </option>
                            @endforeach

                        </select>

                        @error('id_linea')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted">
                            Seleccione la línea a la que está asignado el bus.
                        </small>
                    </div>

                    {{-- Fecha --}}
                    <div class="col-md-6 mb-3">
                        <label for="fecha" class="form-label">
                            Fecha del recorrido
                        </label>

                        <input type="date"
                               name="fecha"
                               id="fecha"
                               class="form-control @error('fecha') is-invalid @enderror"
                               value="{{ old('fecha', date('Y-m-d')) }}"
                               required>

                        @error('fecha')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Hora de inicio --}}
                    <div class="col-md-6 mb-3">
                        <label for="hora_inicio" class="form-label">
                            Hora de inicio
                        </label>

                        <input type="time"
                               name="hora_inicio"
                               id="hora_inicio"
                               class="form-control @error('hora_inicio') is-invalid @enderror"
                               value="{{ old('hora_inicio') }}">

                        @error('hora_inicio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Hora de finalización --}}
                    <div class="col-md-6 mb-3">
                        <label for="hora_fin" class="form-label">
                            Hora de finalización
                        </label>

                        <input type="time"
                               name="hora_fin"
                               id="hora_fin"
                               class="form-control @error('hora_fin') is-invalid @enderror"
                               value="{{ old('hora_fin') }}">

                        @error('hora_fin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-6 mb-3">
                        <label for="estado" class="form-label">
                            Estado del recorrido
                        </label>

                        <select name="estado"
                                id="estado"
                                class="form-select @error('estado') is-invalid @enderror"
                                required>

                            @foreach (['Programado', 'En curso', 'Finalizado', 'Cancelado'] as $estado)
                                <option value="{{ $estado }}"
                                    {{ old('estado', 'Programado') == $estado ? 'selected' : '' }}>
                                    {{ $estado }}
                                </option>
                            @endforeach

                        </select>

                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr>

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('recorridos.index') }}"
                       class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Guardar recorrido
                    </button>

                </div>
            </form>

        </div>
    </div>
</div>
@endsection
