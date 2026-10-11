@extends('layouts.app')

@section('title', 'Editar Estación')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-pencil-square"></i>
            Editar Estación
        </h3>

        <a href="{{ route('estaciones.index') }}"
           class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning">
            <h5 class="mb-0">Modificar datos de la estación</h5>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Corrige los siguientes errores:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('estaciones.update', $estacion->id_estacion) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Nombre de la estación</label>
                        <input type="text"
                               name="nombre"
                               class="form-control"
                               value="{{ old('nombre', $estacion->nombre) }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Municipio</label>
                        <select name="id_municipio"
                                class="form-select"
                                required>
                            <option value="">Seleccione un municipio</option>

                            @foreach ($municipios as $municipio)
                                <option value="{{ $municipio->id_municipio }}"
                                    {{ old('id_municipio', $estacion->id_municipio) == $municipio->id_municipio ? 'selected' : '' }}>
                                    {{ $municipio->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Dirección</label>
                        <input type="text"
                               name="direccion"
                               class="form-control"
                               value="{{ old('direccion', $estacion->direccion) }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Capacidad máxima</label>
                        <input type="number"
                               name="capacidad_maxima"
                               class="form-control"
                               min="1"
                               value="{{ old('capacidad_maxima', $estacion->capacidad_maxima) }}"
                               required>
                        <small class="text-muted">
                            Capacidad máxima permitida en la estación.
                        </small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Pasajeros actuales</label>
                        <input type="number"
                               name="pasajeros_actuales"
                               class="form-control"
                               min="0"
                               value="{{ old('pasajeros_actuales', $estacion->pasajeros_actuales) }}"
                               required>
                        <small class="text-muted">
                            Pasajeros que esperan un bus actualmente.
                        </small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Estado</label>
                        <select name="estado"
                                class="form-select"
                                required>
                            <option value="1"
                                {{ old('estado', $estacion->estado) == '1' ? 'selected' : '' }}>
                                Activa
                            </option>
                            <option value="0"
                                {{ old('estado', $estacion->estado) == '0' ? 'selected' : '' }}>
                                Inactiva
                            </option>
                        </select>
                    </div>

                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle"></i>
                        Actualizar estación
                    </button>

                    <a href="{{ route('estaciones.index') }}"
                       class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
