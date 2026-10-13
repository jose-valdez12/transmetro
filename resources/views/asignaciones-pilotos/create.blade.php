
@extends('layouts.app')

@section('title', 'Nueva Asignación de Piloto')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Nueva asignación de piloto</h2>
        <p class="text-muted">
            Seleccione el piloto y el bus correspondiente.
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-person-plus me-2"></i>
            Datos de la asignación
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

            <form action="{{ route('asignaciones-pilotos.store') }}"
                  method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Piloto *</label>

                        <select name="id_piloto"
                                class="form-select @error('id_piloto') is-invalid @enderror"
                                required>
                            <option value="">Seleccione un piloto</option>

                            @foreach($pilotos as $piloto)
                                <option value="{{ $piloto->id_piloto }}"
                                    {{ old('id_piloto') == $piloto->id_piloto ? 'selected' : '' }}>
                                    {{ $piloto->nombres }}
                                    {{ $piloto->apellidos }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Bus *</label>

                        <select name="id_bus"
                                class="form-select @error('id_bus') is-invalid @enderror"
                                required>
                            <option value="">Seleccione un bus</option>

                            @foreach($buses as $bus)
                                <option value="{{ $bus->id_bus }}"
                                    {{ old('id_bus') == $bus->id_bus ? 'selected' : '' }}>
                                    {{ $bus->codigo }}
                                    - {{ $bus->estado }}
                                </option>
                            @endforeach
                        </select>

                        <small class="text-muted">
                            Se muestran buses disponibles o asignados a una línea.
                        </small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Fecha de inicio *</label>

                        <input type="date"
                               name="fecha_inicio"
                               class="form-control @error('fecha_inicio') is-invalid @enderror"
                               value="{{ old('fecha_inicio', date('Y-m-d')) }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Estado inicial</label>

                        <input type="text"
                               class="form-control"
                               value="Activa"
                               readonly>

                        <small class="text-muted">
                            La asignación permanecerá activa hasta que se finalice.
                        </small>
                    </div>

                </div>

                <div class="alert alert-info mt-4 mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    Un piloto y un bus no pueden tener más de una asignación activa.
                    La fecha de finalización se registrará al finalizar la asignación.
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit"
                            class="btn btn-primary"
                            {{ $pilotos->isEmpty() || $buses->isEmpty() ? 'disabled' : '' }}>
                        <i class="bi bi-save me-1"></i>
                        Guardar asignación
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
