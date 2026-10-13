
@extends('layouts.app')

@section('title', 'Editar Parqueo')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Editar parqueo</h2>
        <p class="text-muted">
            Actualice la información del parqueo seleccionado.
        </p>
    </div>

    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-pencil-square me-2"></i>
            Editar parqueo #{{ $parqueo->id_parqueo }}
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

            <form action="{{ route('parqueos.update', $parqueo->id_parqueo) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="codigo" class="form-label">
                            Código del parqueo *
                        </label>

                        <input type="text"
                               name="codigo"
                               id="codigo"
                               class="form-control @error('codigo') is-invalid @enderror"
                               value="{{ old('codigo', $parqueo->codigo) }}"
                               maxlength="50"
                               required>

                        @error('codigo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="estado" class="form-label">
                            Estado *
                        </label>

                        <select name="estado"
                                id="estado"
                                class="form-select @error('estado') is-invalid @enderror"
                                required>

                            <option value="Disponible"
                                {{ old('estado', $parqueo->estado) == 'Disponible' ? 'selected' : '' }}>
                                Disponible
                            </option>

                            <option value="Ocupado"
                                {{ old('estado', $parqueo->estado) == 'Ocupado' ? 'selected' : '' }}>
                                Ocupado
                            </option>

                            <option value="Mantenimiento"
                                {{ old('estado', $parqueo->estado) == 'Mantenimiento' ? 'selected' : '' }}>
                                Mantenimiento
                            </option>

                        </select>

                        @error('estado')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="mt-4 d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Guardar cambios
                    </button>

                    <a href="{{ route('parqueos.index') }}"
                       class="btn btn-secondary">
                        Cancelar
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection
