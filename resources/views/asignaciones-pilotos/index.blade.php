
@extends('layouts.app')

@section('title', 'Asignación de Pilotos')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Asignación de Pilotos</h2>
            <p class="text-muted mb-0">
                Administración de pilotos asignados a los buses de Transmetro.
            </p>
        </div>

        <a href="{{ route('asignaciones-pilotos.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Nueva asignación
        </a>
    </div>

    {{-- Mensajes de confirmación --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle me-2"></i>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-person-vcard me-2"></i>
            Listado de asignaciones
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Piloto</th>
                            <th>Bus</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha de finalización</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($asignaciones as $asignacion)
                            <tr>
                                <td>{{ $asignacion->id_asignacion_piloto }}</td>

                                <td>
                                    @if($asignacion->piloto)
                                        {{ $asignacion->piloto->nombres }}
                                        {{ $asignacion->piloto->apellidos }}
                                    @else
                                        <span class="text-muted">
                                            Piloto no disponible
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $asignacion->bus
                                        ? $asignacion->bus->codigo
                                        : 'Bus no disponible' }}
                                </td>

                                <td>
                                    {{ $asignacion->fecha_inicio
                                        ? $asignacion->fecha_inicio->format('d/m/Y')
                                        : 'Sin fecha' }}
                                </td>

                                <td>
                                    {{ $asignacion->fecha_fin
                                        ? $asignacion->fecha_fin->format('d/m/Y')
                                        : 'Pendiente' }}
                                </td>

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

                                <td>
                                    <div class="d-flex flex-wrap gap-2">

                                        <a href="{{ route('asignaciones-pilotos.show', $asignacion->id_asignacion_piloto) }}"
                                           class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                            Ver
                                        </a>

                                        @if($asignacion->estado)
                                            <a href="{{ route('asignaciones-pilotos.edit', $asignacion->id_asignacion_piloto) }}"
                                               class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                                Editar
                                            </a>

                                            <form action="{{ route('asignaciones-pilotos.finalizar', $asignacion->id_asignacion_piloto) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Está seguro de finalizar esta asignación?');">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                        class="btn btn-success btn-sm">
                                                    <i class="bi bi-check-circle"></i>
                                                    Finalizar
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('asignaciones-pilotos.destroy', $asignacion->id_asignacion_piloto) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('¿Está seguro de eliminar esta asignación del historial?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    No hay asignaciones de pilotos registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $asignaciones->links() }}
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
