
@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-signpost-split me-2"></i>
            Reporte de Recorridos
        </h2>

        <a href="{{ route('reportes.index') }}"
           class="btn btn-secondary">
            Volver
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <h5 class="mb-3">
                Total de recorridos registrados:
                {{ $recorridos->count() }}
            </h5>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Información del recorrido</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($recorridos as $recorrido)
                            <tr>
                                <td>{{ $recorrido->getKey() }}</td>

                                <td>
                                    @foreach($recorrido->getAttributes() as $campo => $valor)
                                        @if(!in_array($campo, [
                                            $recorrido->getKeyName(),
                                            'created_at',
                                            'updated_at'
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
                                    No hay recorridos registrados.
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
