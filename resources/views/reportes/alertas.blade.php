
@extends('layouts.app')

@section('content')

<div class="container py-4">

    <!-- ENCABEZADO -->
    <div class="d-flex justify-content-between align-items-center mb-4 no-imprimir">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Reporte de Alertas
            </h2>

            <p class="text-muted mb-0">
                Consulta de alertas e incidencias registradas en Transmetro.
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
        <h5>Reporte General de Alertas</h5>

        <p class="text-muted small">
            Fecha de generación:
            {{ now()->format('d/m/Y H:i') }}
        </p>
    </div>

    <!-- FILTROS -->
    <div class="card shadow-sm mb-4 no-imprimir">
        <div class="card-body">

            <form method="GET"
                  action="{{ route('reportes.alertas') }}"
                  class="row g-3 align-items-end">

                <!-- BÚSQUEDA -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Buscar alerta
                    </label>

                    <input type="text"
                           name="buscar"
                           class="form-control"
                           placeholder="Descripción o estación"
                           value="{{ $busqueda }}">
                </div>

                <!-- TIPO -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Tipo de alerta
                    </label>

                    <select name="tipo" class="form-select">
                        <option value="">Todos los tipos</option>

                        @foreach($tipos as $opcion)
                            <option value="{{ $opcion }}"
                                {{ (string) $tipo === (string) $opcion ? 'selected' : '' }}>
                                {{ $opcion }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <!-- ESTADO -->
                <div class="col-md-4">
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

                <!-- FECHA INICIAL -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        Fecha inicial
                    </label>

                    <input type="date"
                           name="fecha_inicio"
                           class="form-control"
                           value="{{ $fechaInicio }}">
                </div>

                <!-- FECHA FINAL -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        Fecha final
                    </label>

                    <input type="date"
                           name="fecha_fin"
                           class="form-control"
                           value="{{ $fechaFin }}">
                </div>

                <!-- BUSCAR -->
                <div class="col-md-3">
                    <button type="submit"
                            class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>
                        Buscar
                    </button>
                </div>

                <!-- LIMPIAR -->
                <div class="col-md-3">
                    <a href="{{ route('reportes.alertas') }}"
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
                    Total de alertas:
                    <span class="text-primary">
                        {{ $alertas->count() }}
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
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Estación</th>
                            <th>Recorrido</th>
                            <th>Fecha y hora</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($alertas as $alerta)

                            <tr>
                                <td>
                                    {{ $alerta->id_alerta }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $alerta->tipo }}
                                </td>

                                <td>
                                    {{ $alerta->descripcion ?: 'Sin descripción' }}
                                </td>

                                <td>
                                    {{ $alerta->estacion
                                        ? $alerta->estacion->nombre
                                        : 'Sin estación' }}
                                </td>

                                <td>
                                    {{ $alerta->recorrido
                                        ? 'Recorrido #' . $alerta->recorrido->getKey()
                                        : 'Sin recorrido' }}
                                </td>

                                <td>
                                    {{ $alerta->fecha_hora
                                        ? $alerta->fecha_hora->format('d/m/Y H:i')
                                        : 'Sin fecha' }}
                                </td>

                                <td>
                                    @if($alerta->estado === 'Pendiente')
                                        <span class="badge bg-warning text-dark">
                                            Pendiente
                                        </span>
                                    @elseif($alerta->estado === 'Atendida')
                                        <span class="badge bg-success">
                                            Atendida
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            {{ $alerta->estado ?: 'Sin estado' }}
                                        </span>
                                    @endif
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7"
                                    class="text-center text-muted py-4">
                                    No se encontraron alertas
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
        vertical-align: top;
        overflow-wrap: anywhere;
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

