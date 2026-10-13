
@extends('layouts.app')

@section('title', 'Detalles del Parqueo')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Detalles del parqueo</h2>
        <p class="text-muted">
            Información del parqueo registrado en Transmetro.
        </p>
    </div>

    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-p-square me-2"></i>
            Parqueo #{{ $parqueo->id_parqueo }}
        </div>

        <div class="card-body">

            <table class="table table-bordered align-middle">
                <tbody>

                    <tr>
                        <th style="width: 30%;">ID del parqueo</th>
                        <td>{{ $parqueo->id_parqueo }}</td>
                    </tr>

                    <tr>
                        <th>Código</th>
                        <td>
                            <strong>{{ $parqueo->codigo }}</strong>
                        </td>
                    </tr>

                    <tr>
                        <th>Estado</th>
                        <td>
                            @if($parqueo->estado == 'Disponible')
                                <span class="badge bg-success">
                                    Disponible
                                </span>
                            @elseif($parqueo->estado == 'Ocupado')
                                <span class="badge bg-danger">
                                    Ocupado
                                </span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    Mantenimiento
                                </span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Fecha de registro</th>
                        <td>
                            {{ $parqueo->created_at
                                ? $parqueo->created_at->format('d/m/Y H:i')
                                : 'Sin fecha' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Última actualización</th>
                        <td>
                            {{ $parqueo->updated_at
                                ? $parqueo->updated_at->format('d/m/Y H:i')
                                : 'Sin fecha' }}
                        </td>
                    </tr>

                </tbody>
            </table>

            <div class="d-flex gap-2 mt-3">

                <a href="{{ route('parqueos.edit', $parqueo->id_parqueo) }}"
                   class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i>
                    Editar
                </a>

                <a href="{{ route('parqueos.index') }}"
                   class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver al listado
                </a>

            </div>

        </div>
    </div>

</div>
@endsection
