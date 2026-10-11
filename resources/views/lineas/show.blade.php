
@extends('layouts.app')

@section('title', 'Detalle de la línea')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2 class="mb-1">Detalle de la línea</h2>
        <p class="text-muted mb-0">
            Consulta la información de la línea de transporte registrada en el sistema.
        </p>
    </div>

    {{-- Tarjeta de información --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-signpost-2 me-2"></i>
            Información de la línea
        </div>

        <div class="card-body">

            <div class="row">

                {{-- ID de la línea --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold">
                        ID de la línea
                    </label>

                    <div class="form-control bg-light">
                        {{ $linea->id_linea }}
                    </div>
                </div>

                {{-- Nombre --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold">
                        Nombre de la línea
                    </label>

                    <div class="form-control bg-light">
                        {{ $linea->nombre }}
                    </div>
                </div>

                {{-- Distancia total --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold">
                        Distancia total
                    </label>

                    <div class="form-control bg-light">
                        {{ $linea->distancia_total }} km
                    </div>
                </div>

                {{-- Municipio --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold">
                        Municipio
                    </label>

                    <div class="form-control bg-light">
                        {{ $linea->municipio->nombre ?? 'Sin municipio' }}
                    </div>
                </div>

                {{-- Estado --}}
                <div class="col-md-6 mb-4">
                    <label class="form-label fw-bold d-block">
                        Estado de la línea
                    </label>

                    <div class="form-control bg-light">
                        @if ($linea->estado)
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>
                                Activa
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="bi bi-x-circle me-1"></i>
                                Inactiva
                            </span>
                        @endif
                    </div>
                </div>

            </div>

            <hr class="my-4">

            {{-- Botones --}}
            <div class="d-flex flex-wrap gap-2">

                <a href="{{ route('lineas.edit', $linea->id_linea) }}"
                   class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i>
                    Editar línea
                </a>

                <a href="{{ route('lineas.index') }}"
                   class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i>
                    Volver a líneas
                </a>

            </div>

        </div>
    </div>

</div>
@endsection
