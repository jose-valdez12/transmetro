
@extends('layouts.app')

@section('title', 'Editar Asignación de Guardia')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Editar asignación de guardia</h2>
        <p class="text-muted">
            Actualice la información de la asignación seleccionada.
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-pencil-square me-2"></i>
            Editar asignación #{{ $asignacion->id_asignacion_guardia }}
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

            <form action="{{ route('asignacion-guardia.update', $asignacion->id_asignacion_guardia) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Guardia *</label>

                        <select name="id_guardia"
                                class="form-select @error('id_guardia') is-invalid @enderror"
                                required>
                            <option value="">Seleccione un guardia</option>

                            @foreach($guardias as $guardia)
                                <option value="{{ $guardia->id_guardia }}"
                                    {{ old('id_guardia', $asignacion->id_guardia) == $guardia->id_guardia ? 'selected' : '' }}>
                                    {{ $guardia->nombres }}
                                    {{ $guardia->apellidos }}
                                    {{ !$guardia->estado ? '(Inactivo)' : '' }}
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
                                    {{ old('id_acceso', $asignacion->id_acceso) == $acceso->id_acceso ? 'selected' : '' }}>
                                    Acceso #{{ $acceso->id_acceso }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Fecha de inicio *</label>

                        <input type="date"
                               name="fecha_inicio"
                               class="form-control @error('fecha_inicio') is-invalid @enderror"
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
