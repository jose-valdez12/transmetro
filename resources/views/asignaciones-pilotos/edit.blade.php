
@extends('layouts.app')

@section('title', 'Editar Asignación de Piloto')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Editar asignación de piloto</h2>
        <p class="text-muted">
            Actualice la información de la asignación seleccionada.
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-pencil-square me-2"></i>
            Editar asignación #{{ $asignacion->id_asignacion_piloto }}
        </div>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('asignaciones-pilotos.update', $asignacion->id_asignacion_piloto) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Piloto *</label>

                        <select name="id_piloto"
                                class="form-select"
                                required>
                            <option value="">Seleccione un piloto</option>

                            @foreach($pilotos as $piloto)
                                <option value="{{ $piloto->id_piloto }}"
                                    {{ old('id_piloto', $asignacion->id_piloto) == $piloto->id_piloto ? 'selected' : '' }}>
                                    {{ $piloto->nombres }}
                                    {{ $piloto->apellidos }}
                                    {{ !$piloto->estado ? '(Inactivo)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Bus *</label>

                        <select name="id_bus"
                                class="form-select"
                                required>
                            <option value="">Seleccione un bus</option>

                            @foreach($buses as $bus)
                                <option value="{{ $bus->id_bus }}"
                                    {{ old('id_bus', $asignacion->id_bus) == $bus->id_bus ? 'selected' : '' }}>
                                    {{ $bus->codigo }}
                                    - {{ $bus->estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Fecha de inicio *</label>

                        <input type="date"
                               name="fecha_inicio"
                               class="form-control"
                               value="{{ old('fecha_inicio', $asignacion->fecha_inicio ? $asignacion->fecha_inicio->format('Y-m-d') : '') }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Estado</label>

                        <input type="text"
                               class="form-control"
                               value="Activa"
                               readonly>

                        <small class="text-muted">
                            Para finalizar la asignación, utilice el botón
                            Finalizar del listado.
                        </small>
                    </div>

                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Guardar cambios
                    </button>

                    <a href="{{ route('asignaciones-pilotos.index') }}"
                       class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
