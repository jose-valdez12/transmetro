
@extends('layouts.app')

@section('title', 'Detalles del Piloto')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Detalles del piloto</h2>
        <p class="text-muted">
            Información del piloto registrado en Transmetro.
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-person-badge me-2"></i>
            Piloto #{{ $piloto->id_piloto }}
        </div>

        <div class="card-body">

            <table class="table table-bordered align-middle">
                <tbody>
                    <tr>
                        <th style="width: 30%;">ID del piloto</th>
                        <td>{{ $piloto->id_piloto }}</td>
                    </tr>

                    <tr>
                        <th>Nombres</th>
                        <td>{{ $piloto->nombres }}</td>
                    </tr>

                    <tr>
                        <th>Apellidos</th>
                        <td>{{ $piloto->apellidos }}</td>
                    </tr>

                    <tr>
                        <th>Teléfono</th>
                        <td>{{ $piloto->telefono ?? 'No registrado' }}</td>
                    </tr>

                    <tr>
                        <th>Dirección</th>
                        <td>{{ $piloto->direccion ?? 'No registrada' }}</td>
                    </tr>

                    <tr>
                        <th>Estado</th>
                        <td>
                            @if($piloto->estado)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Fecha de registro</th>
                        <td>
                            {{ $piloto->created_at
                                ? $piloto->created_at->format('d/m/Y H:i')
                                : 'Sin fecha' }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('pilotos.edit', $piloto->id_piloto) }}"
                   class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i>
                    Editar
                </a>

                <a href="{{ route('pilotos.index') }}"
                   class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver al listado
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
