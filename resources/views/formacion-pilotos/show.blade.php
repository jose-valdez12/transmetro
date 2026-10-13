
@extends('layouts.app')

@section('title', 'Detalles de Formación')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Detalles de la formación</h2>
        <p class="text-muted">
            Información de la capacitación registrada en Transmetro.
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-mortarboard me-2"></i>
            Formación #{{ $formacion->id_formacion }}
        </div>

        <div class="card-body">

            <table class="table table-bordered align-middle">
                <tbody>

                    <tr>
                        <th style="width: 30%;">ID de formación</th>
                        <td>{{ $formacion->id_formacion }}</td>
                    </tr>

                    <tr>
                        <th>Piloto</th>
                        <td>
                            @if($formacion->piloto)
                                {{ $formacion->piloto->nombres }}
                                {{ $formacion->piloto->apellidos }}
                            @else
                                Piloto no disponible
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Institución</th>
                        <td>{{ $formacion->institucion }}</td>
                    </tr>

                    <tr>
                        <th>Título de formación</th>
                        <td>{{ $formacion->titulo }}</td>
                    </tr>

                    <tr>
                        <th>Fecha de formación</th>
                        <td>
                            {{ $formacion->fecha
                                ? $formacion->fecha->format('d/m/Y')
                                : 'No registrada' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Fecha de registro</th>
                        <td>
                            {{ $formacion->created_at
                                ? $formacion->created_at->format('d/m/Y H:i')
                                : 'Sin fecha' }}
                        </td>
                    </tr>

                </tbody>
            </table>

            <div class="d-flex gap-2 mt-3">

                <a href="{{ route('formacion-pilotos.edit', $formacion->id_formacion) }}"
                   class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i>
                    Editar
                </a>

                <a href="{{ route('formacion-pilotos.index') }}"
                   class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver al listado
                </a>

            </div>

        </div>
    </div>

</div>
@endsection
