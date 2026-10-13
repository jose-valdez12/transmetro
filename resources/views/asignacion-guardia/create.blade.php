
@extends('layouts.app')

@section('title', 'Nueva Asignación de Guardia')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Nueva asignación de guardia</h2>
        <p class="text-muted">
            Seleccione el guardia y el acceso correspondiente.
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

            <form action="{{ route('asignacion-guardia.store') }}"
                  method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Guardia *</label>

                        <select name="id_guardia"
                                class="form-select @error('id_guardia') is-invalid @enderror"
                                required>
                            <option value="">Seleccione un guardia</option>

                            @foreach($guardias as $guardia)
                                <option value="{{ $guardia->id_guardia }}"
                                    {{ old('id_guardia') == $guardia->id_guardia ? 'selected' : '' }}>
                                    {{ $guardia->nombres }}
                                    {{ $guardia->apellidos }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Acceso *</label>

                        <select name="id_acceso"
                                class="form-select @error('id_acceso') is-invalid @enderror"
                                required>
                            <option value="">Seleccione un acceso</option>

                            @foreach($accesos as $acceso)
                                <option value="{{ $acceso->id_acceso }}"
                                    {{ old('id_acceso') == $acceso->id_acceso ? 'selected' : '' }}>
                                    Acceso #{{ $acceso->id_acceso }}
                                </option>
                            @endforeach
                        </select>

                        <small class="text-muted">
                            Seleccione el acceso de la estación donde trabajará el guardia.
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
                    Un guardia no puede tener dos asignaciones activas.
                    Un mismo acceso puede contar con varios guardias.
                </div>

                <div class="mt-4 d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary"
                            {{ $guardias->isEmpty() || $accesos->isEmpty() ? 'disabled' : '' }}>
                        <i class="bi bi-save me-1"></i>
                        Guardar asignación
                    </button>

                    <a href="{{ route('asignacion-guardia.index') }}"
                       class="btn btn-secondary">
                        Cancelar
                    </a>

                </div>
            </form>

        </div>
    </div>

</div>
@endsection
