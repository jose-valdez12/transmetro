
@extends('layouts.app')

@section('title', 'Registrar Formación')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Registrar formación de piloto</h2>
        <p class="text-muted">
            Ingrese la información de la capacitación recibida.
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-mortarboard me-2"></i>
            Datos de la formación
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

            <form action="{{ route('formacion-pilotos.store') }}"
                  method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Piloto *</label>

                        <select name="id_piloto"
                                class="form-select @error('id_piloto') is-invalid @enderror"
                                required>
                            <option value="">Seleccione un piloto</option>

                            @foreach($pilotos as $piloto)
                                <option value="{{ $piloto->id_piloto }}"
                                    {{ old('id_piloto') == $piloto->id_piloto ? 'selected' : '' }}>
                                    {{ $piloto->nombres }}
                                    {{ $piloto->apellidos }}
                                </option>
                            @endforeach
                        </select>

                        @if($pilotos->isEmpty())
                            <small class="text-danger">
                                No hay pilotos activos disponibles.
                                Primero debe registrar o activar un piloto.
                            </small>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Institución *</label>

                        <input type="text"
                               name="institucion"
                               class="form-control @error('institucion') is-invalid @enderror"
                               value="{{ old('institucion') }}"
                               maxlength="150"
                               placeholder="Ej. INTECAP"
                               required>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Título de la formación *</label>

                        <input type="text"
                               name="titulo"
                               class="form-control @error('titulo') is-invalid @enderror"
                               value="{{ old('titulo') }}"
                               maxlength="150"
                               placeholder="Ej. Capacitación en conducción defensiva"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Fecha de formación</label>

                        <input type="date"
                               name="fecha"
                               class="form-control @error('fecha') is-invalid @enderror"
                               value="{{ old('fecha') }}">
                    </div>

                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit"
                            class="btn btn-primary"
                            {{ $pilotos->isEmpty() ? 'disabled' : '' }}>
                        <i class="bi bi-save me-1"></i>
                        Guardar formación
                    </button>

                    <a href="{{ route('formacion-pilotos.index') }}"
                       class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
