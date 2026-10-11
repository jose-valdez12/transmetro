
@extends('layouts.app')

@section('title', 'Registrar bus')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2 class="mb-1">Registrar bus</h2>
        <p class="text-muted mb-0">
            Ingresa la información necesaria para registrar un nuevo bus
            en el sistema de transporte.
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

    {{-- Formulario --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-bus-front me-2"></i>
            Información del bus
        </div>

        <div class="card-body">

            <form action="{{ route('buses.store') }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Código del bus --}}
                    <div class="col-md-6 mb-3">
                        <label for="codigo" class="form-label">
                            Código del bus
                        </label>

                        <input
                            type="text"
                            class="form-control @error('codigo') is-invalid @enderror"
                            id="codigo"
                            name="codigo"
                            value="{{ old('codigo') }}"
                            placeholder="Ej. BUS-001"
                            maxlength="50"
                            required
                        >

                        @error('codigo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Capacidad máxima --}}
                    <div class="col-md-6 mb-3">
                        <label for="capacidad_maxima" class="form-label">
                            Capacidad máxima de pasajeros
                        </label>

                        <input
                            type="number"
                            class="form-control @error('capacidad_maxima') is-invalid @enderror"
                            id="capacidad_maxima"
                            name="capacidad_maxima"
                            value="{{ old('capacidad_maxima') }}"
                            placeholder="Ej. 80"
                            min="1"
                            step="1"
                            required
                        >

                        @error('capacidad_maxima')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-6 mb-3">
                        <label for="estado" class="form-label">
                            Estado del bus
                        </label>

                        <select
                            class="form-select @error('estado') is-invalid @enderror"
                            id="estado"
                            name="estado"
                            required
                        >
                            <option value="">Seleccione un estado</option>

                            <option value="Disponible"
                                {{ old('estado', 'Disponible') == 'Disponible' ? 'selected' : '' }}>
                                Disponible
                            </option>

                            <option value="Asignado"
                                {{ old('estado') == 'Asignado' ? 'selected' : '' }}>
                                Asignado
                            </option>

                            <option value="Mantenimiento"
                                {{ old('estado') == 'Mantenimiento' ? 'selected' : '' }}>
                                Mantenimiento
                            </option>

                            <option value="Fuera de servicio"
                                {{ old('estado') == 'Fuera de servicio' ? 'selected' : '' }}>
                                Fuera de servicio
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
                        <i class="bi bi-save me-1"></i>
                        Guardar bus
                    </button>

                    <a href="{{ route('buses.index') }}"
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
