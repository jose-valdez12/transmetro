
@extends('layouts.app')

@section('title', 'Registrar alerta')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Registrar nueva alerta</h2>
        <p class="text-muted">
            Registre las situaciones que requieren atención
            durante los recorridos del sistema de transporte.
        </p>
    </div>

    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Información de la alerta
        </div>

        <div class="card-body">

            {{-- Errores de validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>No se pudo registrar la alerta.</strong>

                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('alertas.store') }}"
                  method="POST">

                @csrf

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
                                    {{ old('id_recorrido') == $recorrido->id_recorrido ? 'selected' : '' }}>

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
                                    {{ old('id_estacion') == $estacion->id_estacion ? 'selected' : '' }}>

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
                            Debe seleccionar al menos un recorrido o una estación.
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

                            <option value="Alta demanda de pasajeros"
                                {{ old('tipo') == 'Alta demanda de pasajeros' ? 'selected' : '' }}>
                                Alta demanda de pasajeros
                            </option>

                            <option value="Falla mecánica"
                                {{ old('tipo') == 'Falla mecánica' ? 'selected' : '' }}>
                                Falla mecánica
                            </option>

                            <option value="Retraso en recorrido"
                                {{ old('tipo') == 'Retraso en recorrido' ? 'selected' : '' }}>
                                Retraso en recorrido
                            </option>

                            <option value="Incidente en estación"
                                {{ old('tipo') == 'Incidente en estación' ? 'selected' : '' }}>
                                Incidente en estación
                            </option>

                            <option value="Emergencia"
                                {{ old('tipo') == 'Emergencia' ? 'selected' : '' }}>
                                Emergencia
                            </option>

                            <option value="Otro"
                                {{ old('tipo') == 'Otro' ? 'selected' : '' }}>
                                Otro
                            </option>

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
                               value="{{ old('fecha_hora', now()->format('Y-m-d\TH:i')) }}"
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
                                  placeholder="Describa la situación que requiere atención..."
                                  required>{{ old('descripcion') }}</textarea>

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
                                {{ old('estado', 'Pendiente') == 'Pendiente' ? 'selected' : '' }}>
                                Pendiente
                            </option>

                            <option value="Atendida"
                                {{ old('estado') == 'Atendida' ? 'selected' : '' }}>
                                Atendida
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

                    <a href="{{ route('alertas.index') }}"
                       class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Cancelar
                    </a>

                    <button type="submit"
                            class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Guardar alerta
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection
