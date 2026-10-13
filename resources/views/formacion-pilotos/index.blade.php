
@extends('layouts.app')

@section('title', 'Formación de Pilotos')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Formación de Pilotos</h2>
            <p class="text-muted mb-0">
                Administración de las capacitaciones de los pilotos de Transmetro.
            </p>
        </div>

        <a href="{{ route('formacion-pilotos.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Nueva formación
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-mortarboard me-2"></i>
            Listado de formaciones registradas
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Piloto</th>
                            <th>Institución</th>
                            <th>Título</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($formaciones as $formacion)
                            <tr>
                                <td>{{ $formacion->id_formacion }}</td>

                                <td>
                                    @if($formacion->piloto)
                                        {{ $formacion->piloto->nombres }}
                                        {{ $formacion->piloto->apellidos }}
                                    @else
                                        <span class="text-muted">
                                            Piloto no disponible
                                        </span>
                                    @endif
                                </td>

                                <td>{{ $formacion->institucion }}</td>

                                <td>{{ $formacion->titulo }}</td>

                                <td>
                                    {{ $formacion->fecha
                                        ? $formacion->fecha->format('d/m/Y')
                                        : 'Sin fecha' }}
                                </td>

                                <td>
                                    <div class="d-flex flex-wrap gap-2">

                                        <a href="{{ route('formacion-pilotos.show', $formacion->id_formacion) }}"
                                           class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> Ver
                                        </a>

                                        <a href="{{ route('formacion-pilotos.edit', $formacion->id_formacion) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                            Editar
                                        </a>

                                        <form action="{{ route('formacion-pilotos.destroy', $formacion->id_formacion) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar esta formación?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                                Eliminar
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    No hay formaciones registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $formaciones->links() }}
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ url('/') }}" class="btn btn-secondary">
            <i class="bi bi-house-door me-1"></i>
            Volver al inicio
        </a>
    </div>

</div>
@endsection
