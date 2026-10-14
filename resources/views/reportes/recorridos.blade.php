
@extends('layouts.app')

@section('content')

<div class="container py-4">

    <!-- ENCABEZADO -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-imprimir">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-sign-turn-right me-2"></i>
                Reporte de Recorridos
            </h2>

            <p class="text-muted mb-0">
                Consulta de recorridos realizados en Transmetro.
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
        <h5>Reporte General de Recorridos</h5>

        <p class="text-muted small">
            Fecha de generación:
            {{ now()->format('d/m/Y H:i') }}
        </p>
    </div>

    <!-- FILTROS -->
    <div class="card shadow-sm mb-4 no-imprimir">
        <div class="card-body">

            <form method="GET"
                  action="{{ route('reportes.recorridos') }}"
                  class="row g-3 align-items-end">

                <!-- BÚSQUEDA POR BUS -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Código del bus
                    </label>

                    <input type="text"
                           name="buscar"
                           class="form-control"
                           placeholder="Buscar por código"
                           value="{{ $busqueda }}">
                </div>

                <!-- ESTADO -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Estado del recorrido
                    </label>

                    <select name="estado" class="form-select">

                        <option value="">Todos los estados</option>

                        @foreach($estados as $opcion)
                            <option value="{{ $opcion }}"
                                {{ (string) $estado === (string) $opcion ? 'selected' : '' }}>
                                {{ $opcion }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <!-- FECHA INICIAL -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold">
                        Fecha inicial
                    </label>

                    <input type="date"
                           name="fecha_inicio"
                           class="form-control"
                           value="{{ $fechaInicio }}">
                </div>

                <!-- FECHA FINAL -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold">
                        Fecha final
                    </label>

                    <input type="date"
                           name="fecha_fin"
                           class="form-control"
                           value="{{ $fechaFin }}">
                </div>

                <div class="col-md-3">
                    <button type="submit"
                            class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>
                        Buscar
                    </button>
                </div>

                <div class="col-md-3">
                    <a href="{{ route('reportes.recorridos') }}"
                       class="btn btn-outline-secondary w-100">
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
                    Total de recorridos:
                    <span class="text-primary">
                        {{ $recorridos->count() }}
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
                            <th>Bus</th>
                            <th>Línea</th>
                            <th>Fecha</th>
                            <th>Hora inicio</th>
                            <th>Hora fin</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($recorridos as $recorrido)

                            <tr>
                                <td>
                                    {{ $recorrido->id_recorrido }}
                                </td>

                                <td>
                                    {{ $recorrido->bus
                                        ? $recorrido->bus->codigo
                                        : 'Sin bus' }}
                                </td>

                                <td>
                                    {{ $recorrido->linea
                                        ? $recorrido->linea->getKey()
                                        : 'Sin línea' }}
                                </td>

                                <td>
                                    {{ $recorrido->fecha
                                        ? $recorrido->fecha->format('d/m/Y')
                                        : 'Sin fecha' }}
                                </td>

                                <td>
                                    {{ $recorrido->hora_inicio ?: 'Pendiente' }}
                                </td>

                                <td>
                                    {{ $recorrido->hora_fin ?: 'Pendiente' }}
                                </td>

                                <td>
                                    {{ $recorrido->estado }}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7"
                                    class="text-center text-muted py-4">
                                    No se encontraron recorridos
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

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    th, td {
        border: 1px solid #000 !important;
        padding: 6px !important;
    }

    tr {
        page-break-inside: avoid;
    }

    @page {
        size: landscape;
        margin: 12mm;
    }

}

</style>

@endsection
