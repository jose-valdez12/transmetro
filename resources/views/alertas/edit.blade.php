
@extends('layouts.app')

@section('title', 'Editar Alerta')

@section('content')
<div class="container-fluid">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Editar Alerta</h2>
            <p class="text-muted mb-0">
                Modifique la información de la alerta #{{ $alerta->id_alerta }}.
            </p>
        </div>

        <a href="{{ route('alertas.index') }}"
           class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Volver
        </a>
    </div>

    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-pencil-square me-2"></i>
            Actualizar información de la alerta
        </div>

        <div class="card-body">

            {{-- Errores de validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>No se pudo actualizar la alerta.</strong>

                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('alertas.update', $alerta->id_alerta) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Recorrido --}}
                    <div class="col-md-6 mb-3">
                        <label for="id_recorrido" class="form-label">
                            Recorrido relacionado
                        </label>

                        <select name="id_recorrido"
                                id="id_recorrido"
                                class="form-select @error('id_recorrido') is-invalid @enderror">

                            <option value="">Sin recorrido específico</option>

                            @foreach ($recorridos as $recorrido)
                                <option value="{{ $recorrido->id_recorrido }}"
                                    {{ old('id_recorrido', $alerta->id_recorrido) == $recorrido->id_recorrido ? 'selected' : '' }}>

                                    Recorrido #{{ $recorrido->id_recorrido }}
                                    - {{ $recorrido->bus->codigo ?? 'Sin bus' }}
                                    - {{ $recorrido->linea->nombre ?? 'Sin línea' }}

                                </option>
                            @endforeach

                        </select>

                        @error('id_recorrido')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Estación --}}
                    <div class="col-md-6 mb-3">
                        <label for="id_estacion" class="form-label">
                            Estación relacionada
                        </label>

                        <select name="id_estacion"
                                id="id_estacion"
                                class="form-select @error('id_estacion') is-invalid @enderror">

                            <option value="">Sin estación específica</option>

                            @foreach ($estaciones as $estacion)
                                <option value="{{ $estacion->id_estacion }}"
                                    {{ old('id_estacion', $alerta->id_estacion) == $estacion->id_estacion ? 'selected' : '' }}>

                                    {{ $estacion->nombre }}

                                </option>
                            @endforeach

                        </select>

                        @error('id_estacion')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <small class="text-muted">
                            Debe existir al menos un recorrido o una estación relacionada.
                        </small>
                    </div>

                    {{-- Tipo de alerta --}}
                    <div class="col-md-6 mb-3">
                        <label for="tipo" class="form-label">
                            Tipo de alerta
                        </label>

                        <select name="tipo"
                                id="tipo"
                                class="form-select @error('tipo') is-invalid @enderror"
                                required>

                            <option value="">Seleccione un tipo</option>

                            @foreach ([
                                'Alta demanda de pasajeros',
                                'Falla mecánica',
                                'Retraso en recorrido',
                                'Incidente en estación',
                                'Emergencia',
                                'Otro'
                            ] as $tipo)

                                <option value="{{ $tipo }}"
                                    {{ old('tipo', $alerta->tipo) == $tipo ? 'selected' : '' }}>
                                    {{ $tipo }}
                                </option>

                            @endforeach

                        </select>

                        @error('tipo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Fecha y hora --}}
                    <div class="col-md-6 mb-3">
                        <label for="fecha_hora" class="form-label">
                            Fecha y hora de la alerta
                        </label>

                        <input type="datetime-local"
                               name="fecha_hora"
                               id="fecha_hora"
                               class="form-control @error('fecha_hora') is-invalid @enderror"
                               value="{{ old('fecha_hora', $alerta->fecha_hora ? $alerta->fecha_hora->format('Y-m-d\TH:i') : '') }}"
                               required>

                        @error('fecha_hora')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div class="col-md-12 mb-3">
                        <label for="descripcion" class="form-label">
                            Descripción de la alerta
                        </label>

                        <textarea name="descripcion"
                                  id="descripcion"
                                  rows="4"
                                  class="form-control @error('descripcion') is-invalid @enderror"
                                  required>{{ old('descripcion', $alerta->descripcion) }}</textarea>

                        @error('descripcion')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-6 mb-3">
                        <label for="estado" class="form-label">
                            Estado de la alerta
                        </label>

                        <select name="estado"
                                id="estado"
                                class="form-select @error('estado') is-invalid @enderror"
                                required>

                            <option value="Pendiente"
                                {{ old('estado', $alerta->estado) == 'Pendiente' ? 'selected' : '' }}>
                                Pendiente
                            </option>

                            <option value="Atendida"
                                {{ old('estado', $alerta->estado) == 'Atendida' ? 'selected' : '' }}>
                                Atendida
                            </option>

                        </select>

                        @error('estado')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <small class="text-muted">
                            Seleccione Atendida cuando la situación haya sido resuelta.
                        </small>
                    </div>

                </div>

                <hr>

                {{-- Botones --}}
                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('alertas.index') }}"
                       class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>
                        Cancelar
                    </a>

                    <button type="submit"
                            class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Guardar cambios
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection
