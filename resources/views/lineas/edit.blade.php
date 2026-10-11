
@extends('layouts.app')

@section('title', 'Editar línea')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2 class="mb-1">Editar línea de transporte</h2>
        <p class="text-muted mb-0">
            Modifica la información de la línea de transporte seleccionada.
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

    {{-- Tarjeta del formulario --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-pencil-square me-2"></i>
            Información de la línea
        </div>

        <div class="card-body">

            <form action="{{ route('lineas.update', $linea->id_linea) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Nombre de la línea --}}
                    <div class="col-md-6 mb-3">
                        <label for="nombre" class="form-label">
                            Nombre de la línea
                        </label>

                        <input
                            type="text"
                            class="form-control @error('nombre') is-invalid @enderror"
                            id="nombre"
                            name="nombre"
                            value="{{ old('nombre', $linea->nombre) }}"
                            placeholder="Ej. Línea 1"
                            required
                        >

                        @error('nombre')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Distancia total --}}
                    <div class="col-md-6 mb-3">
                        <label for="distancia_total" class="form-label">
                            Distancia total (km)
                        </label>

                        <input
                            type="number"
                            class="form-control @error('distancia_total') is-invalid @enderror"
                            id="distancia_total"
                            name="distancia_total"
                            value="{{ old('distancia_total', $linea->distancia_total) }}"
                            placeholder="Ej. 12.50"
                            step="0.01"
                            min="0"
                            required
                        >

                        @error('distancia_total')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
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
                            <option value="">
                                Seleccione un municipio
                            </option>

                            @foreach ($municipios as $municipio)
                                <option
                                    value="{{ $municipio->id_municipio }}"
                                    {{ old('id_municipio', $linea->id_municipio) == $municipio->id_municipio ? 'selected' : '' }}
                                >
                                    {{ $municipio->nombre }}
                                </option>
                            @endforeach

                        </select>

                        @error('id_municipio')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-6 mb-3">
                        <label for="estado" class="form-label">
                            Estado de la línea
                        </label>

                        <select
                            class="form-select @error('estado') is-invalid @enderror"
                            id="estado"
                            name="estado"
                            required
                        >
                            <option value="1"
                                {{ old('estado', (string) $linea->estado) == '1' ? 'selected' : '' }}>
                                Activa
                            </option>

                            <option value="0"
                                {{ old('estado', (string) $linea->estado) == '0' ? 'selected' : '' }}>
                                Inactiva
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
                        Actualizar línea
                    </button>

                    <a href="{{ route('lineas.index') }}"
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
