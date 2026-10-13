
@extends('layouts.app')

@section('title', 'Editar Formación')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Editar formación de piloto</h2>
        <p class="text-muted">
            Actualice la información de la formación registrada.
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-pencil-square me-2"></i>
            Editar formación #{{ $formacion->id_formacion }}
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

            <form action="{{ route('formacion-pilotos.update', $formacion->id_formacion) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Piloto *</label>

                        <select name="id_piloto"
                                class="form-select"
                                required>
                            <option value="">Seleccione un piloto</option>

                            @foreach($pilotos as $piloto)
                                <option value="{{ $piloto->id_piloto }}"
                                    {{ old('id_piloto', $formacion->id_piloto) == $piloto->id_piloto ? 'selected' : '' }}>
                                    {{ $piloto->nombres }}
                                    {{ $piloto->apellidos }}
                                    {{ !$piloto->estado ? '(Inactivo)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Institución *</label>

                        <input type="text"
                               name="institucion"
                               class="form-control"
                               value="{{ old('institucion', $formacion->institucion) }}"
                               maxlength="150"
                               required>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Título de la formación *</label>

                        <input type="text"
                               name="titulo"
                               class="form-control"
                               value="{{ old('titulo', $formacion->titulo) }}"
                               maxlength="150"
                               required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Fecha de formación</label>

                        <input type="date"
                               name="fecha"
                               class="form-control"
                               value="{{ old('fecha', $formacion->fecha ? $formacion->fecha->format('Y-m-d') : '') }}">
                    </div>

                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Guardar cambios
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
