
@extends('layouts.app')

@section('title', 'Nueva asignación de bus')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Nueva asignación de bus</h2>
        <p class="text-muted">
            Seleccione el bus y la línea de transporte a la que será asignado.
        </p>
    </div>

    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-bus-front me-2"></i>
            Registro de asignación
        </div>

        <div class="card-body">

            <form action="{{ route('asignacion-bus.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    {{-- Seleccionar bus --}}
                    <div class="col-md-6 mb-3">
                        <label for="id_bus" class="form-label">
                            Bus
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
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
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
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Fecha de inicio --}}
                    <div class="col-md-6 mb-3">
                        <label for="fecha_inicio" class="form-label">
                            Fecha de inicio
                        </label>

                        <input type="date"
                               name="fecha_inicio"
                               id="fecha_inicio"
                               class="form-control @error('fecha_inicio') is-invalid @enderror"
                               value="{{ old('fecha_inicio', date('Y-m-d')) }}"
                               required>

                        @error('fecha_inicio')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Fecha de fin --}}
                    <div class="col-md-6 mb-3">
                        <label for="fecha_fin" class="form-label">
                            Fecha de finalización
                        </label>

                        <input type="date"
                               name="fecha_fin"
                               id="fecha_fin"
                               class="form-control @error('fecha_fin') is-invalid @enderror"
                               value="{{ old('fecha_fin') }}">

                        @error('fecha_fin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <small class="text-muted">
                            Este campo es opcional.
                        </small>
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-6 mb-3">
                        <label for="estado" class="form-label">
                            Estado de la asignación
                        </label>

                        <select name="estado"
                                id="estado"
                                class="form-select @error('estado') is-invalid @enderror"
                                required>

                            <option value="1"
                                {{ old('estado', '1') == '1' ? 'selected' : '' }}>
                                Activa
                            </option>

                            <option value="0"
                                {{ old('estado') == '0' ? 'selected' : '' }}>
                                Inactiva
                            </option>

                        </select>

                        @error('estado')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <hr>

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('asignacion-bus.index') }}"
                       class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Guardar asignación
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection
