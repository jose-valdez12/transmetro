
@extends('layouts.app')

@section('content')

<div class="container py-4">

    <!-- ENCABEZADO -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-imprimir">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-p-square me-2"></i>
                Reporte de Parqueos
            </h2>

            <p class="text-muted mb-0">
                Consulta de parqueos registrados en Transmetro.
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
        <h5>Reporte General de Parqueos</h5>

        <p class="text-muted small">
            Fecha de generación:
            {{ now()->format('d/m/Y H:i') }}
        </p>
    </div>

    <!-- FILTROS -->
    <div class="card shadow-sm mb-4 no-imprimir">
        <div class="card-body">

            <form method="GET"
                  action="{{ route('reportes.parqueos') }}"
                  class="row g-3 align-items-end">

                <!-- BÚSQUEDA POR CÓDIGO -->
                <div class="col-md-5">
                    <label class="form-label fw-semibold">
                        Buscar parqueo
                    </label>

                    <input type="text"
                           name="buscar"
                           class="form-control"
                           placeholder="Ingrese el código del parqueo"
                           value="{{ $busqueda }}">
                </div>

                <!-- ESTADO -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        Estado del parqueo
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

                <!-- BOTÓN BUSCAR -->
                <div class="col-md-2">
                    <button type="submit"
                            class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>
                        Buscar
                    </button>
                </div>

                <!-- BOTÓN LIMPIAR -->
                <div class="col-md-2">
                    <a href="{{ route('reportes.parqueos') }}"
                       class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-clockwise me-1"></i>
                        Limpiar
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
                    Total de parqueos:
                    <span class="text-primary">
                        {{ $parqueos->count() }}
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
                            <th>Código del parqueo</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($parqueos as $parqueo)

                            <tr>
                                <td>
                                    {{ $parqueo->id_parqueo }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $parqueo->codigo }}
                                </td>

                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $parqueo->estado === null
                                            ? 'Sin estado'
                                            : $parqueo->estado }}
                                    </span>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="3"
                                    class="text-center text-muted py-4">
                                    No se encontraron parqueos
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
        font-size: 12px;
    }

    th, td {
        border: 1px solid #000 !important;
        padding: 8px !important;
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
        margin: 12mm;
    }

}

</style>

@endsection
