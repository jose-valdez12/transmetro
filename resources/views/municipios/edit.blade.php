
@extends('layouts.app')

@section('title', 'Editar municipio')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2 class="mb-1">Editar municipio</h2>
        <p class="text-muted mb-0">
            Modifica la información del municipio seleccionado.
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

    {{-- Formulario de edición --}}
    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-pencil-square me-2"></i>
            Información del municipio
        </div>

        <div class="card-body">

            <form action="{{ route('municipios.update', $municipios->id_municipio) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Nombre del municipio --}}
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">
                            Nombre del municipio
                        </label>

                        <input
                            type="text"
                            class="form-control @error('nombre') is-invalid @enderror"
                            id="nombre"
                            name="nombre"
                            value="{{ old('nombre', $municipios->nombre) }}"
                            placeholder="Ej. Puerto Barrios"
                            required
                        >

                        @error('nombre')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Departamento --}}
                    <div class="col-md-6 mb-3">
                        <label for="departamento" class="form-label">
                            Departamento
                        </label>

                        <input
                            type="text"
                            class="form-control @error('departamento') is-invalid @enderror"
                            id="departamento"
                            name="departamento"
                            value="{{ old('departamento', $municipios->departamento) }}"
                            placeholder="Ej. Izabal"
                            required
                        >

                        @error('departamento')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-6 mb-3">
                        <label for="estado" class="form-label">
                            Estado del municipio
                        </label>

                        <select
                            class="form-select @error('estado') is-invalid @enderror"
                            id="estado"
                            name="estado"
                            required
                        >
                            <option value="1"
                                {{ old('estado', (string) $municipios->estado) == '1' ? 'selected' : '' }}>
                                Activo
                            </option>

                            <option value="0"
                                {{ old('estado', (string) $municipios->estado) == '0' ? 'selected' : '' }}>
                                Inactivo
                            </option>
                        </select>

                        @error('estado')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4">

                {{-- Botones --}}
                <div class="d-flex flex-wrap gap-2">

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>
                        Actualizar municipio
                    </button>

                    <a href="{{ route('municipios.index') }}"
                       class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>
                        Cancelar
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection
