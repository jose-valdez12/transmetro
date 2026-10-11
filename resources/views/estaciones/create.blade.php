 @extends('layouts.app')

@section('title', 'Registrar estación')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2 class="mb-1">Registrar estación</h2>
        <p class="text-muted mb-0">
            Ingresa la información necesaria para registrar una nueva estación de transporte.
        </p>
    </div>

    {{-- Mensajes de error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Verifica los siguientes campos:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-train-front me-2"></i>
            Información de la estación
        </div>

        <div class="card-body">
            <form action="{{ route('estaciones.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Nombre de la estación --}}
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">
                            Nombre de la estación
                        </label>

                        <input
                            type="text"
                            class="form-control @error('nombre') is-invalid @enderror"
                            id="nombre"
                            name="nombre"
                            value="{{ old('nombre') }}"
                            placeholder="Ej. Estación Central"
                            maxlength="100"
                            required
                        >

                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Dirección --}}
                    <div class="col-md-6 mb-3">
                        <label for="direccion" class="form-label">
                            Dirección
                        </label>

                        <input
                            type="text"
                            class="form-control @error('direccion') is-invalid @enderror"
                            id="direccion"
                            name="direccion"
                            value="{{ old('direccion') }}"
                            placeholder="Ingresa la dirección de la estación"
                            maxlength="255"
                            required
                        >

                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Municipio --}}
                    <div class="col-md-6 mb-3">
                        <label for="id_municipio" class="form-label">
                            Municipio
                        </label>

                        <select
                            class="form-select @error('id_municipio') is-invalid @enderror"
                            id="id_municipio"
                            name="id_municipio"
                            required
                        >
                            <option value="">Seleccione un municipio</option>

                            @foreach ($municipios as $municipio)
                                <option
                                    value="{{ $municipio->id_municipio }}"
                                    {{ old('id_municipio') == $municipio->id_municipio ? 'selected' : '' }}
                                >
                                    {{ $municipio->nombre }}
                                </option>
                            @endforeach
                        </select>

                        @error('id_municipio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-6 mb-3">
                        <label for="estado" class="form-label">
                            Estado de la estación
                        </label>

                        <select
                            class="form-select @error('estado') is-invalid @enderror"
                            id="estado"
                            name="estado"
                            required
                        >
                            <option value="1" {{ old('estado', '1') == '1' ? 'selected' : '' }}>
                                Activa
                            </option>

                            <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>
                                Inactiva
                            </option>
                        </select>

                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4">

                {{-- Botones --}}
                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Guardar estación
                    </button>

                    <a href="{{ route('estaciones.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
