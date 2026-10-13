
@extends('layouts.app')

@section('title', 'Detalles del Guardia')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Detalles del guardia</h2>
        <p class="text-muted">
            Información del personal de seguridad registrado.
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-shield-check me-2"></i>
            Guardia #{{ $guardia->id_guardia }}
        </div>

        <div class="card-body">

            <table class="table table-bordered align-middle">
                <tbody>

                    <tr>
                        <th style="width: 30%;">ID del guardia</th>
                        <td>{{ $guardia->id_guardia }}</td>
                    </tr>

                    <tr>
                        <th>Nombres</th>
                        <td>{{ $guardia->nombres }}</td>
                    </tr>

                    <tr>
                        <th>Apellidos</th>
                        <td>{{ $guardia->apellidos }}</td>
                    </tr>

                    <tr>
                        <th>Teléfono</th>
                        <td>{{ $guardia->telefono ?: 'No registrado' }}</td>
                    </tr>

                    <tr>
                        <th>Estado</th>
                        <td>
                            @if($guardia->estado)
                                <span class="badge bg-success">
                                    Activo
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    Inactivo
                                </span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Fecha de registro</th>
                        <td>
                            {{ $guardia->created_at
                                ? $guardia->created_at->format('d/m/Y H:i')
                                : 'Sin fecha' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Última actualización</th>
                        <td>
                            {{ $guardia->updated_at
                                ? $guardia->updated_at->format('d/m/Y H:i')
                                : 'Sin fecha' }}
                        </td>
                    </tr>

                </tbody>
            </table>

            <div class="d-flex flex-wrap gap-2 mt-3">

                <a href="{{ route('guardias.edit', $guardia->id_guardia) }}"
                   class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i>
                    Editar
                </a>

                <a href="{{ route('guardias.index') }}"
                   class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver al listado
                </a>

            </div>

        </div>
    </div>

</div>
@endsection
