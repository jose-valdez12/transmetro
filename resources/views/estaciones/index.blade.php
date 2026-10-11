
@extends('layouts.app')

@section('title', 'Estaciones')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            <i class="bi bi-geo-alt-fill"></i>
            Gestión de Estaciones
        </h3>

        <a href="{{ route('estaciones.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Nueva estación
        </a>
    </div>

    {{-- Mensajes del sistema --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-list-ul"></i>
                Listado de estaciones
            </h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Estación</th>
                            <th>Municipio</th>
                            <th>Capacidad máxima</th>
                            <th>Pasajeros actuales</th>
                            <th>Ocupación</th>
                            <th>Situación</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($estaciones as $estacion)

                            @php
                                $porcentaje = $estacion->porcentajeOcupacion();

                                if ($porcentaje >= 150) {
                                    $color = 'danger';
                                    $situacion = 'Alta demanda';
                                } elseif ($porcentaje >= 100) {
                                    $color = 'warning';
                                    $situacion = 'Capacidad completa o excedida';
                                } else {
                                    $color = 'success';
                                    $situacion = 'Normal';
                                }

                                // La barra visual llega como máximo al 100%
                                $anchoBarra = min($porcentaje, 100);
                            @endphp

                            <tr>
                                <td>{{ $estacion->id_estacion }}</td>

                                <td class="fw-semibold">
                                    {{ $estacion->nombre }}
                                </td>

                                <td>
                                    {{ $estacion->municipio->nombre ?? 'Sin municipio' }}
                                </td>

                                <td>
                                    {{ $estacion->capacidad_maxima }}
                                </td>

                                <td>
                                    {{ $estacion->pasajeros_actuales }}
                                </td>

                                <td style="min-width: 150px;">

                                    <span class="fw-semibold">
                                        {{ number_format($porcentaje, 1) }}%
                                    </span>

                                    <div class="progress mt-1"
                                         style="height: 9px;">

                                        <div class="progress-bar bg-{{ $color }}"
                                             role="progressbar"
                                             style="width: {{ $anchoBarra }}%;"
                                             aria-valuenow="{{ $porcentaje }}"
                                             aria-valuemin="0"
                                             aria-valuemax="150">
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    <span class="badge bg-{{ $color }} {{ $color == 'warning' ? 'text-dark' : '' }}">
                                        @if($porcentaje >= 150)
                                            <i class="bi bi-exclamation-triangle-fill"></i>
                                        @elseif($porcentaje >= 100)
                                            <i class="bi bi-exclamation-circle"></i>
                                        @else
                                            <i class="bi bi-check-circle"></i>
                                        @endif

                                        {{ $situacion }}
                                    </span>
                                </td>

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

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">

                                        <a href="{{ route('estaciones.show', $estacion->id_estacion) }}"
                                           class="btn btn-sm btn-info text-white"
                                           title="Consultar">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('estaciones.edit', $estacion->id_estacion) }}"
                                           class="btn btn-sm btn-warning"
                                           title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('estaciones.destroy', $estacion->id_estacion) }}"
                                              method="POST"
                                              onsubmit="return confirm('¿Estás seguro de eliminar esta estación?');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="9"
                                    class="text-center text-muted py-4">
                                    No hay estaciones registradas.
                                </td>
                            </tr>

                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- Paginación --}}
            <div class="mt-3">
                {{ $estaciones->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
