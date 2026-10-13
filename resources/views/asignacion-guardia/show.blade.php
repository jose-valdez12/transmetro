
@extends('layouts.app')

@section('title', 'Detalles de Asignación de Guardia')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Detalles de asignación</h2>
        <p class="text-muted">
            Información del guardia asignado a un acceso de Transmetro.
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-shield-check me-2"></i>
            Asignación #{{ $asignacion->id_asignacion_guardia }}
        </div>

        <div class="card-body">

            <table class="table table-bordered align-middle">
                <tbody>

                    <tr>
                        <th style="width: 30%;">ID de asignación</th>
                        <td>{{ $asignacion->id_asignacion_guardia }}</td>
                    </tr>

                    <tr>
                        <th>Guardia</th>
                        <td>
                            @if($asignacion->guardia)
                                {{ $asignacion->guardia->nombres }}
                                {{ $asignacion->guardia->apellidos }}
                            @else
                                Guardia no disponible
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Acceso</th>
                        <td>
                            @if($asignacion->acceso)
                                Acceso #{{ $asignacion->acceso->id_acceso }}
                            @else
                                Acceso no disponible
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Fecha de inicio</th>
                        <td>
                            {{ $asignacion->fecha_inicio
                                ? $asignacion->fecha_inicio->format('d/m/Y')
                                : 'Sin fecha' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Fecha de finalización</th>
                        <td>
                            {{ $asignacion->fecha_fin
                                ? $asignacion->fecha_fin->format('d/m/Y')
                                : 'Pendiente' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Estado</th>
                        <td>
                            @if($asignacion->estado)
                                <span class="badge bg-success">
                                    Activa
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    Finalizada
                                </span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Fecha de registro</th>
                        <td>
                            {{ $asignacion->created_at
                                ? $asignacion->created_at->format('d/m/Y H:i')
                                : 'Sin fecha' }}
                        </td>
                    </tr>

                </tbody>
            </table>

            <div class="d-flex flex-wrap gap-2 mt-3">

                @if($asignacion->estado)
                    <a href="{{ route('asignaciones-guardias.edit', $asignacion->id_asignacion_guardia) }}"
                       class="btn btn-warning">
                        <i class="bi bi-pencil-square me-1"></i>
                        Editar
                    </a>
                @endif

                <a href="{{ route('asignacion-guardia.index') }}"
                   class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver al listado
                </a>

            </div>

        </div>
    </div>

</div>
@endsection
