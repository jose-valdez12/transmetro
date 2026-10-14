
@extends('layouts.app')

@section('content')

<div class="container py-4">

    <!-- ENCABEZADO -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-imprimir">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-geo-alt me-2"></i>
                Reporte de Estaciones
            </h2>

            <p class="text-muted mb-0">
                Consulta de estaciones registradas en Transmetro.
            </p>
        </div>

        <a href="{{ route('reportes.index') }}"
           class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Volver
        </a>

    </div>

    <!-- ENCABEZADO DEL REPORTE -->
    <div class="mb-4">
        <h4 class="fw-bold">Sistema Transmetro</h4>
        <h5>Reporte General de Estaciones</h5>

        <p class="text-muted small">
            Fecha de generación:
            {{ now()->format('d/m/Y H:i') }}
        </p>
    </div>

    <!-- FILTROS -->
    <div class="card shadow-sm mb-4 no-imprimir">
        <div class="card-body">

            <form method="GET"
                  action="{{ route('reportes.estaciones') }}"
                  class="row g-3 align-items-end">

                <!-- BÚSQUEDA -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Buscar estación
                    </label>

                    <input type="text"
                           name="buscar"
                           class="form-control"
                           placeholder="Nombre o dirección"
                           value="{{ $busqueda }}">
                </div>

                <!-- ESTADO -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        Estado
                    </label>

                    <select name="estado" class="form-select">
                        <option value="">Todos los estados</option>

                        <option value="1"
                            {{ (string) $estado === '1' ? 'selected' : '' }}>
                            Activa
                        </option>

                        <option value="0"
                            {{ (string) $estado === '0' ? 'selected' : '' }}>
                            Inactiva
                        </option>
                    </select>
                </div>

                <!-- MUNICIPIO -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        Municipio
                    </label>

                    <select name="municipio" class="form-select">
                        <option value="">Todos los municipios</option>

                        @foreach($municipios as $item)
                            <option value="{{ $item->id_municipio }}"
                                {{ (string) $municipio === (string) $item->id_municipio ? 'selected' : '' }}>
                                Municipio #{{ $item->id_municipio }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- BUSCAR -->
                <div class="col-md-2">
                    <button type="submit"
                            class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>
                        Buscar
                    </button>
                </div>

                <!-- LIMPIAR -->
                <div class="col-md-3">
                    <a href="{{ route('reportes.estaciones') }}"
                       class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Limpiar filtros
                    </a>
                </div>

            </form>

        </div>
    </div>

    <!-- TABLA DEL REPORTE -->
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="fw-bold mb-0">
                    Total de estaciones:
                    <span class="text-primary">
                        {{ $estaciones->count() }}
                    </span>
                </h5>

                <button type="button"
                        onclick="window.print()"
                        class="btn btn-success no-imprimir">
                    <i class="bi bi-printer me-1"></i>
                    Imprimir
                </button>

            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Estación</th>
                            <th>Dirección</th>
                            <th>Municipio</th>
                            <th>Capacidad máxima</th>
                            <th>Pasajeros actuales</th>
                            <th>Ocupación</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($estaciones as $estacion)

                            <tr>
                                <td>
                                    {{ $estacion->id_estacion }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $estacion->nombre }}
                                </td>

                                <td>
                                    {{ $estacion->direccion ?: 'No registrada' }}
                                </td>

                                <td>
                                    {{ $estacion->municipio
                                        ? 'Municipio #' . $estacion->municipio->getKey()
                                        : 'Sin municipio' }}
                                </td>

                                <td>
                                    {{ $estacion->capacidad_maxima }}
                                </td>

                                <td>
                                    {{ $estacion->pasajeros_actuales }}
                                </td>

                                <td>
                                    @php
                                        $ocupacion = $estacion->porcentajeOcupacion();
                                    @endphp

                                    @if($ocupacion >= 100)
                                        <span class="badge bg-danger">
                                            {{ number_format($ocupacion, 1) }}%
                                        </span>
                                    @elseif($ocupacion >= 80)
                                        <span class="badge bg-warning text-dark">
                                            {{ number_format($ocupacion, 1) }}%
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            {{ number_format($ocupacion, 1) }}%
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($estacion->estado)
                                        <span class="badge bg-success">
                                            Activa
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            Inactiva
                                        </span>
                                    @endif
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="8"
                                    class="text-center text-muted py-4">
                                    No se encontraron estaciones
                                    con los filtros seleccionados.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

<!-- ESTILOS PARA IMPRESIÓN -->
<style>

@media print {

    .no-imprimir,
    nav,
    .navbar,
    aside,
    .sidebar,
    footer {
        display: none !important;
    }

    body {
        background: white !important;
    }

    .container {
        max-width: 100% !important;
    }

    .card {
        border: none !important;
        box-shadow: none !important;
    }

    .table-responsive {
        overflow: visible !important;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
    }

    th, td {
        border: 1px solid #000 !important;
        padding: 5px !important;
    }

    tr {
        page-break-inside: avoid;
    }

    .badge {
        color: #000 !important;
        background: transparent !important;
        border: 1px solid #000;
    }

    @page {
        size: landscape;
        margin: 10mm;
    }

}

</style>

@endsection
