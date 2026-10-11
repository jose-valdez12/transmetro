
@extends('layouts.app')

@section('title', 'Registrar visita a estación')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Registrar visita a estación</h2>
        <p class="text-muted">
            Registre la llegada y salida de un bus a una estación,
            así como la cantidad de pasajeros que transporta.
        </p>
    </div>

    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-geo-alt me-2"></i>
            Nueva visita a estación
        </div>

        <div class="card-body">

            {{-- Mensajes de validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>No se pudo registrar la visita.</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('visitas.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Recorrido --}}
                    <div class="col-md-6 mb-3">
                        <label for="id_recorrido" class="form-label">
                            Recorrido
                        </label>

                        <select name="id_recorrido"
                                id="id_recorrido"
                                class="form-select @error('id_recorrido') is-invalid @enderror"
                                required>

                            <option value="">Seleccione un recorrido</option>

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
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted">
                            Solo se muestran los recorridos en curso.
                        </small>
                    </div>

                    {{-- Estación --}}
                    <div class="col-md-6 mb-3">
                        <label for="id_estacion" class="form-label">
                            Estación
                        </label>

                        <select name="id_estacion"
                                id="id_estacion"
                                class="form-select @error('id_estacion') is-invalid @enderror"
                                required>

                            <option value="">Seleccione una estación</option>

                            @foreach ($estaciones as $estacion)
                                <option value="{{ $estacion->id_estacion }}"
                                    {{ old('id_estacion') == $estacion->id_estacion ? 'selected' : '' }}>
                                    {{ $estacion->nombre }}
                                </option>
                            @endforeach

                        </select>

                        @error('id_estacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted">
                            La estación debe pertenecer a la línea del recorrido.
                        </small>
                    </div>

                    {{-- Fecha y hora de llegada --}}
                    <div class="col-md-6 mb-3">
                        <label for="fecha_hora_llegada" class="form-label">
                            Fecha y hora de llegada
                        </label>

                        <input type="datetime-local"
                               name="fecha_hora_llegada"
                               id="fecha_hora_llegada"
                               class="form-control @error('fecha_hora_llegada') is-invalid @enderror"
                               value="{{ old('fecha_hora_llegada') }}"
                               required>

                        @error('fecha_hora_llegada')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Fecha y hora de salida --}}
                    <div class="col-md-6 mb-3">
                        <label for="fecha_hora_salida" class="form-label">
                            Fecha y hora de salida
                        </label>

                        <input type="datetime-local"
                               name="fecha_hora_salida"
                               id="fecha_hora_salida"
                               class="form-control @error('fecha_hora_salida') is-invalid @enderror"
                               value="{{ old('fecha_hora_salida') }}">

                        @error('fecha_hora_salida')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted">
                            Puede dejar este campo vacío si el bus todavía
                            permanece en la estación.
                        </small>
                    </div>

                    {{-- Cantidad de pasajeros --}}
                    <div class="col-md-6 mb-3">
                        <label for="cantidad_pasajeros" class="form-label">
                            Cantidad de pasajeros a bordo
                        </label>

                        <input type="number"
                               name="cantidad_pasajeros"
                               id="cantidad_pasajeros"
                               class="form-control @error('cantidad_pasajeros') is-invalid @enderror"
                               value="{{ old('cantidad_pasajeros', 0) }}"
                               min="0"
                               required>

                        @error('cantidad_pasajeros')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <small class="text-muted">
                            La cantidad no debe superar la capacidad máxima del bus.
                        </small>
                    </div>

                </div>

                <hr>

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('visitas.index') }}"
                       class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Guardar visita
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection
