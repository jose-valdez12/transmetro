
@extends('layouts.app')

@section('title', 'Detalle de Estación')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            <i class="bi bi-geo-alt-fill"></i>
            Detalle de Estación
        </h3>

        <a href="{{ route('estaciones.index') }}"
           class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    @php
        $porcentaje = $estacion->porcentajeOcupacion();

        if ($porcentaje >= 150) {
            $color = 'danger';
            $situacion = 'Alta demanda';
            $mensaje = 'La estación ha superado el límite establecido. Se requiere enviar otro bus.';
        } elseif ($porcentaje >= 100) {
            $color = 'warning';
            $situacion = 'Capacidad completa o excedida';
            $mensaje = 'La estación ha alcanzado o superado su capacidad normal.';
        } else {
            $color = 'success';
            $situacion = 'Normal';
            $mensaje = 'La estación se encuentra dentro de su capacidad normal.';
        }

        $anchoBarra = min($porcentaje, 100);
    @endphp

    <div class="row g-4">

        <!-- Información general -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle"></i>
                        Información general
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered align-middle">
                        <tbody>
                            <tr>
                                <th width="40%">Código</th>
                                <td>{{ $estacion->id_estacion }}</td>
                            </tr>

                            <tr>
                                <th>Nombre</th>
                                <td>{{ $estacion->nombre }}</td>
                            </tr>

                            <tr>
                                <th>Dirección</th>
                                <td>{{ $estacion->direccion }}</td>
                            </tr>

                            <tr>
                                <th>Municipio</th>
                                <td>
                                    {{ $estacion->municipio->nombre ?? 'Sin municipio' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Estado</th>
                                <td>
                                    @if($estacion->estado)
                                        <span class="badge bg-success">
                                            Activa
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Inactiva
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Control de pasajeros -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-people-fill"></i>
                        Control de pasajeros
                    </h5>
                </div>

                <div class="card-body">

                    <div class="row text-center mb-4">
                        <div class="col-6">
                            <h3 class="fw-bold">
                                {{ $estacion->capacidad_maxima }}
                            </h3>
                            <p class="text-muted mb-0">
                                Capacidad máxima
                            </p>
                        </div>

                        <div class="col-6">
                            <h3 class="fw-bold">
                                {{ $estacion->pasajeros_actuales }}
                            </h3>
                            <p class="text-muted mb-0">
                                Pasajeros actuales
                            </p>
                        </div>
                    </div>

                    <h6 class="fw-bold">
                        Porcentaje de ocupación
                    </h6>

                    <h3 class="fw-bold text-{{ $color }}">
                        {{ number_format($porcentaje, 1) }}%
                    </h3>

                    <div class="progress mb-3" style="height: 20px;">
                        <div class="progress-bar bg-{{ $color }}"
                             role="progressbar"
                             style="width: {{ $anchoBarra }}%;">
                        </div>
                    </div>

                    <div class="alert alert-{{ $color }}">
                        <strong>{{ $situacion }}</strong>
                        <p class="mb-0 mt-1">
                            {{ $mensaje }}
                        </p>
                    </div>

                    @if($porcentaje >= 150)
                        <p class="text-danger fw-semibold">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            Se ha alcanzado el límite de alerta del 150%.
                        </p>
                    @endif

                </div>

            </div>
        </div>

    </div>

    <!-- Botones -->
    <div class="mt-4 d-flex gap-2">

        <a href="{{ route('estaciones.edit', $estacion->id_estacion) }}"
           class="btn btn-warning">
            <i class="bi bi-pencil-square"></i>
            Editar estación
        </a>

        <a href="{{ route('estaciones.index') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-list-ul"></i>
            Ver estaciones
        </a>

    </div>

</div>
@endsection
