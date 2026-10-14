
@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Reporte de Alertas
        </h2>

        <a href="{{ route('reportes.index') }}"
           class="btn btn-secondary">
            Volver
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3">
                Total de alertas registradas:
                {{ $alertas->count() }}
            </h5>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Información de la alerta</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($alertas as $alerta)
                            <tr>
                                <td>{{ $alerta->getKey() }}</td>

                                <td>
                                    @foreach($alerta->getAttributes() as $campo => $valor)
                                        @if(!in_array($campo, [
                                            $alerta->getKeyName(),
                                            'created_at',
                                            'updated_at',
                                            'password',
                                            'remember_token'
                                        ]))
                                            <div class="mb-1">
                                                <strong>
                                                    {{ ucwords(str_replace('_', ' ', $campo)) }}:
                                                </strong>

                                                {{ $valor === null ? 'Sin información' : $valor }}
                                            </div>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">
                                    No hay alertas registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection
