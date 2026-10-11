
@extends('layouts.app')

@section('title', 'Detalle del municipio')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2 class="mb-1">Detalle del municipio</h2>
        <p class="text-muted mb-0">
            Consulta la información del municipio registrado en el sistema.
        </p>
    </div>

    {{-- Tarjeta de información --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-geo-alt me-2"></i>
            Información del municipio
        </div>

        <div class="card-body">

            <div class="row">

                {{-- ID --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold">
                        ID del municipio
                    </label>

                    <div class="form-control bg-light">
                        {{ $municipios->id_municipio }}
                    </div>
                </div>

                {{-- Nombre --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold">
                        Nombre del municipio
                    </label>

                    <div class="form-control bg-light">
                        {{ $municipios->nombre }}
                    </div>
                </div>

                {{-- Departamento --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold">
                        Departamento
                    </label>

                    <div class="form-control bg-light">
                        {{ $municipios->departamento }}
                    </div>
                </div>

                {{-- Estado --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold d-block">
                        Estado del municipio
                    </label>

                    <div class="form-control bg-light">
                        @if ($municipios->estado)
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>
                                Activo
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="bi bi-x-circle me-1"></i>
                                Inactivo
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <hr class="my-4">

            {{-- Botones --}}
            <div class="d-flex flex-wrap gap-2">

                <a href="{{ route('municipios.edit', $municipios->id_municipio) }}"
                   class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i>
                    Editar municipio
                </a>

                <a href="{{ route('municipios.index') }}"
                   class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i>
                    Volver a municipios
                </a>

            </div>

        </div>
    </div>

</div>
@endsection
