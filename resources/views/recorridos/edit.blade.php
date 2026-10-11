
@extends('layouts.app')

@section('title', 'Editar recorrido')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Editar recorrido</h2>
        <p class="text-muted">
            Modifique los datos del recorrido seleccionado.
        </p>
    </div>

    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-pencil-square me-2"></i>
            Editar recorrido #{{ $recorrido->id_recorrido }}
        </div>

        <div class="card-body">

            {{-- Mensajes de validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>No se pudieron guardar los cambios.</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('recorridos.update', $recorrido->id_recorrido) }}"
                  method="POST">

                @csrf
                @method('PUT')

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
                                    {{ old('id_bus', $recorrido->id_bus) == $bus->id_bus ? 'selected' : '' }}>
                                    {{ $bus->codigo }} - {{ $bus->estado }}
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
                                    {{ old('id_linea', $recorrido->id_linea) == $linea->id_linea ? 'selected' : '' }}>
                                    {{ $linea->nombre }}
                                </option>
                            @endforeach

                        </select>

                        @error('id_linea')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                               value="{{ old('fecha', $recorrido->fecha ? $recorrido->fecha->format('Y-m-d') : '') }}"
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
                               value="{{ old('hora_inicio', $recorrido->hora_inicio ? substr($recorrido->hora_inicio, 0, 5) : '') }}">

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
                               value="{{ old('hora_fin', $recorrido->hora_fin ? substr($recorrido->hora_fin, 0, 5) : '') }}">

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
                                    {{ old('estado', $recorrido->estado) == $estado ? 'selected' : '' }}>
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
