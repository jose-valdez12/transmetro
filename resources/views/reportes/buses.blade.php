
@extends('layouts.app')

@section('content')

<div class="container py-4">

    <!-- ENCABEZADO -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-imprimir">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-bus-front me-2"></i>
                Reporte de Buses
            </h2>

            <p class="text-muted mb-0">
                Consulta de buses registrados en Transmetro.
            </p>
        </div>

        <a href="{{ route('reportes.index') }}"
           class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Volver
        </a>

    </div>

    <!-- TÍTULO PARA IMPRESIÓN -->
    <div class="mb-4">
        <h4 class="fw-bold">Sistema Transmetro</h4>
        <h5>Reporte General de Buses</h5>

        <p class="text-muted small">
            Fecha de generación:
            {{ now()->format('d/m/Y H:i') }}
        </p>
    </div>

    <!-- FILTROS -->
    <div class="card shadow-sm mb-4 no-imprimir">
        <div class="card-body">

            <form method="GET"
                  action="{{ route('reportes.buses') }}"
                  class="row g-3 align-items-end">

                <div class="col-md-5">
                    <label class="form-label fw-semibold">
                        Buscar por código
                    </label>

                    <input type="text"
                           name="buscar"
                           class="form-control"
                           placeholder="Ingrese el código del bus"
                           value="{{ $busqueda }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        Estado
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

                <div class="col-md-2">
                    <button type="submit"
                            class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>
                        Buscar
                    </button>
                </div>

                <div class="col-md-2">
                    <a href="{{ route('reportes.buses') }}"
                       class="btn btn-outline-secondary w-100">
                        Limpiar
                    </a>
                </div>

            </form>

        </div>
    </div>

    <!-- REPORTE -->
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="fw-bold mb-0">
                    Total de buses:
                    <span class="text-primary">
                        {{ $buses->count() }}
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
                            <th>Código del bus</th>
                            <th>Capacidad máxima</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($buses as $bus)

                            <tr>
                                <td>{{ $bus->id_bus }}</td>

                                <td class="fw-semibold">
                                    {{ $bus->codigo }}
                                </td>

                                <td>
                                    {{ $bus->capacidad_maxima }}
                                    pasajeros
                                </td>

                                <td>
                                    {{ $bus->estado }}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="4"
                                    class="text-center text-muted py-4">
                                    No se encontraron buses
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
    }

    th, td {
        border: 1px solid #000 !important;
        padding: 8px !important;
    }

    tr {
        page-break-inside: avoid;
    }

}

</style>

@endsection
