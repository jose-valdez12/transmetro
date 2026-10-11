
@extends('layouts.app')

@section('title', 'Editar asignación de bus')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Editar asignación de bus</h2>
        <p class="text-muted">
            Modifique la información de la asignación seleccionada.
        </p>
    </div>

    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-pencil-square me-2"></i>
            Editar asignación #{{ $asignacion->id_asignacion }}
        </div>

        <div class="card-body">

            <form action="{{ route('asignacion-bus.update', $asignacion->id_asignacion) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Bus --}}
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
                                    {{ old('id_bus', $asignacion->id_bus) == $bus->id_bus ? 'selected' : '' }}>
                                    {{ $bus->codigo }}
                                    - {{ $bus->estado }}
                                </option>
                            @endforeach

                        </select>

                        @error('id_bus')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Línea --}}
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
                                    {{ old('id_linea', $asignacion->id_linea) == $linea->id_linea ? 'selected' : '' }}>
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
                               value="{{ old('fecha_inicio', $asignacion->fecha_inicio ? $asignacion->fecha_inicio->format('Y-m-d') : '') }}"
                               required>

                        @error('fecha_inicio')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Fecha de finalización --}}
                    <div class="col-md-6 mb-3">
                        <label for="fecha_fin" class="form-label">
                            Fecha de finalización
                        </label>

                        <input type="date"
                               name="fecha_fin"
                               id="fecha_fin"
                               class="form-control @error('fecha_fin') is-invalid @enderror"
                               value="{{ old('fecha_fin', $asignacion->fecha_fin ? $asignacion->fecha_fin->format('Y-m-d') : '') }}">

                        @error('fecha_fin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <small class="text-muted">
                            Puede dejar este campo vacío.
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
                                {{ old('estado', (int) $asignacion->estado) == 1 ? 'selected' : '' }}>
                                Activa
                            </option>

                            <option value="0"
                                {{ old('estado', (int) $asignacion->estado) == 0 ? 'selected' : '' }}>
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

                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save me-1"></i>
                        Guardar cambios
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection
