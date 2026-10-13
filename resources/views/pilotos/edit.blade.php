
@extends('layouts.app')

@section('title', 'Editar Piloto')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Editar piloto</h2>
        <p class="text-muted">
            Actualice la información del piloto seleccionado.
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-pencil-square me-2"></i>
            Editar piloto #{{ $piloto->id_piloto }}
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

            <form action="{{ route('pilotos.update', $piloto->id_piloto) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Nombres *</label>
                        <input type="text" name="nombres"
                               class="form-control"
                               value="{{ old('nombres', $piloto->nombres) }}"
                               maxlength="100" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Apellidos *</label>
                        <input type="text" name="apellidos"
                               class="form-control"
                               value="{{ old('apellidos', $piloto->apellidos) }}"
                               maxlength="100" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono"
                               class="form-control"
                               value="{{ old('telefono', $piloto->telefono) }}"
                               maxlength="30">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Estado *</label>
                        <select name="estado" class="form-select" required>
                            <option value="1"
                                {{ old('estado', (int)$piloto->estado) == '1' ? 'selected' : '' }}>
                                Activo
                            </option>
                            <option value="0"
                                {{ old('estado', (int)$piloto->estado) == '0' ? 'selected' : '' }}>
                                Inactivo
                            </option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Dirección</label>
                        <textarea name="direccion" class="form-control"
                                  rows="3" maxlength="255">{{ old('direccion', $piloto->direccion) }}</textarea>
                    </div>

                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Guardar cambios
                    </button>

                    <a href="{{ route('pilotos.index') }}"
                       class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
