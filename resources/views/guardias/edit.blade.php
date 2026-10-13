
@extends('layouts.app')

@section('title', 'Editar Guardia')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Editar guardia</h2>
        <p class="text-muted">
            Modifique los datos del guardia seleccionado.
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-pencil-square me-2"></i>
            Editar guardia #{{ $guardia->id_guardia }}
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

            <form action="{{ route('guardias.update', $guardia->id_guardia) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Nombres *</label>
                        <input type="text"
                               name="nombres"
                               class="form-control @error('nombres') is-invalid @enderror"
                               value="{{ old('nombres', $guardia->nombres) }}"
                               maxlength="100"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Apellidos *</label>
                        <input type="text"
                               name="apellidos"
                               class="form-control @error('apellidos') is-invalid @enderror"
                               value="{{ old('apellidos', $guardia->apellidos) }}"
                               maxlength="100"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Teléfono</label>
                        <input type="text"
                               name="telefono"
                               class="form-control @error('telefono') is-invalid @enderror"
                               value="{{ old('telefono', $guardia->telefono) }}"
                               maxlength="30">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Estado *</label>
                        <select name="estado"
                                class="form-select @error('estado') is-invalid @enderror"
                                required>
                            <option value="1"
                                {{ old('estado', $guardia->estado ? '1' : '0') == '1' ? 'selected' : '' }}>
                                Activo
                            </option>
                            <option value="0"
                                {{ old('estado', $guardia->estado ? '1' : '0') == '0' ? 'selected' : '' }}>
                                Inactivo
                            </option>
                        </select>

                        <small class="text-muted">
                            Un guardia con asignaciones activas no puede desactivarse.
                        </small>
                    </div>

                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Guardar cambios
                    </button>

                    <a href="{{ route('guardias.index') }}"
                       class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
