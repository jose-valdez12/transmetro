
@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-shield-check me-2"></i>
            Reporte de Guardias
        </h2>

        <a href="{{ route('reportes.index') }}"
           class="btn btn-secondary">
            Volver
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3">
                Total de guardias registrados:
                {{ $guardias->count() }}
            </h5>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Información del guardia</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($guardias as $guardia)
                            <tr>
                                <td>{{ $guardia->getKey() }}</td>

                                <td>
                                    @foreach($guardia->getAttributes() as $campo => $valor)
                                        @if(!in_array($campo, [
                                            $guardia->getKeyName(),
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
                                    No hay guardias registrados.
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
