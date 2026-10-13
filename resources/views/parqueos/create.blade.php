
@extends('layouts.app')

@section('title', 'Registrar Parqueo')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Registrar parqueo</h2>
        <p class="text-muted">
            Ingrese la información del nuevo parqueo.
        </p>
    </div>

    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-plus-circle me-2"></i>
            Datos del parqueo
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

            <form action="{{ route('parqueos.store') }}"
                  method="POST">

                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="codigo" class="form-label">
                            Código del parqueo *
                        </label>

                        <input type="text"
                               name="codigo"
                               id="codigo"
                               class="form-control @error('codigo') is-invalid @enderror"
                               value="{{ old('codigo') }}"
                               placeholder="Ejemplo: P-001"
                               maxlength="50"
                               required>

                        @error('codigo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <small class="text-muted">
                            El código debe ser único.
                        </small>
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
                                {{ old('estado', 'Disponible') == 'Disponible' ? 'selected' : '' }}>
                                Disponible
                            </option>

                            <option value="Ocupado"
                                {{ old('estado') == 'Ocupado' ? 'selected' : '' }}>
                                Ocupado
                            </option>

                            <option value="Mantenimiento"
                                {{ old('estado') == 'Mantenimiento' ? 'selected' : '' }}>
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

                <div class="alert alert-info mt-4">
                    <i class="bi bi-info-circle me-1"></i>
                    El estado del parqueo puede modificarse posteriormente.
                </div>

                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Guardar parqueo
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
