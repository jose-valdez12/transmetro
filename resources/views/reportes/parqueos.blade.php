
@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-p-square me-2"></i>
            Reporte de Parqueos
        </h2>

        <a href="{{ route('reportes.index') }}"
           class="btn btn-secondary">
            Volver
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3">
                Total de parqueos registrados:
                {{ $parqueos->count() }}
            </h5>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Información del parqueo</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($parqueos as $parqueo)
                            <tr>
                                <td>{{ $parqueo->getKey() }}</td>

                                <td>
                                    @foreach($parqueo->getAttributes() as $campo => $valor)
                                        @if(!in_array($campo, [
                                            $parqueo->getKeyName(),
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
                                    No hay parqueos registrados.
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
