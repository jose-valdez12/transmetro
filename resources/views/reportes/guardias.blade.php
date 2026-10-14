
@extends('layouts.app')

@section('content')

<div class="container py-4">

    <!-- ENCABEZADO -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-imprimir">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-shield-check me-2"></i>
                Reporte de Guardias
            </h2>

            <p class="text-muted mb-0">
                Consulta de guardias registrados en Transmetro.
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
        <h5>Reporte General de Guardias</h5>

        <p class="text-muted small">
            Fecha de generación:
            {{ now()->format('d/m/Y H:i') }}
        </p>
    </div>

    <!-- FILTROS -->
    <div class="card shadow-sm mb-4 no-imprimir">
        <div class="card-body">

            <form method="GET"
                  action="{{ route('reportes.guardias') }}"
                  class="row g-3 align-items-end">

                <!-- BÚSQUEDA -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Buscar guardia
                    </label>

                    <input type="text"
                           name="buscar"
                           class="form-control"
                           placeholder="Nombre, apellido o teléfono"
                           value="{{ $busqueda }}">
                </div>

                <!-- ESTADO -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        Estado del guardia
                    </label>

                    <select name="estado" class="form-select">

                        <option value="">Todos los estados</option>

                        <option value="1"
                            {{ (string) $estado === '1' ? 'selected' : '' }}>
                            Activo
                        </option>

                        <option value="0"
                            {{ (string) $estado === '0' ? 'selected' : '' }}>
                            Inactivo
                        </option>

                    </select>
                </div>

                <!-- BOTÓN BUSCAR -->
                <div class="col-md-3">
                    <button type="submit"
                            class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>
                        Buscar
                    </button>
                </div>

                <!-- BOTÓN LIMPIAR -->
                <div class="col-md-3">
                    <a href="{{ route('reportes.guardias') }}"
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
                    Total de guardias:
                    <span class="text-primary">
                        {{ $guardias->count() }}
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
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($guardias as $guardia)

                            <tr>
                                <td>{{ $guardia->id_guardia }}</td>

                                <td>{{ $guardia->nombres }}</td>

                                <td>{{ $guardia->apellidos }}</td>

                                <td>
                                    {{ $guardia->telefono ?: 'No registrado' }}
                                </td>

                                <td>
                                    @if($guardia->estado)
                                        <span class="badge bg-success">
                                            Activo
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5"
                                    class="text-center text-muted py-4">
                                    No se encontraron guardias
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
        padding: 6px !important;
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
