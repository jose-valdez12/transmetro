
@extends('layouts.app')

@section('title', 'Gestión de Recorridos')

@section('content')

<div class="container-fluid">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Gestión de Recorridos</h2>
            <p class="text-muted mb-0">
                Administración y seguimiento de los recorridos de los buses.
            </p>
        </div>

        <a href="{{ route('recorridos.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Nuevo recorrido
        </a>
    </div>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar">
            </button>
        </div>
    @endif

    {{-- Mensaje de error --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar">
            </button>
        </div>
    @endif

    {{-- Tabla de recorridos --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-sign-turn-right me-2"></i>
            Listado de recorridos registrados
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Bus</th>
                            <th>Línea</th>
                            <th>Fecha</th>
                            <th>Hora de inicio</th>
                            <th>Hora de finalización</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($recorridos as $recorrido)

                            <tr>

                                {{-- ID --}}
                                <td>
                                    {{ $recorrido->id_recorrido }}
                                </td>

                                {{-- Bus --}}
                                <td>
                                    {{ $recorrido->bus->codigo ?? 'Sin bus' }}
                                </td>

                                {{-- Línea --}}
                                <td>
                                    {{ $recorrido->linea->nombre ?? 'Sin línea' }}
                                </td>

                                {{-- Fecha --}}
                                <td>
                                    {{ $recorrido->fecha
                                        ? $recorrido->fecha->format('d/m/Y')
                                        : '-' }}
                                </td>

                                {{-- Hora de inicio --}}
                                <td>
                                    {{ $recorrido->hora_inicio
                                        ? substr($recorrido->hora_inicio, 0, 5)
                                        : 'Sin iniciar' }}
                                </td>

                                {{-- Hora de finalización --}}
                                <td>
                                    {{ $recorrido->hora_fin
                                        ? substr($recorrido->hora_fin, 0, 5)
                                        : 'Sin finalizar' }}
                                </td>

                                {{-- Estado --}}
                                <td>
                                    @if ($recorrido->estado == 'Programado')

                                        <span class="badge bg-primary">
                                            Programado
                                        </span>

                                    @elseif ($recorrido->estado == 'En curso')

                                        <span class="badge bg-warning text-dark">
                                            En curso
                                        </span>

                                    @elseif ($recorrido->estado == 'Finalizado')

                                        <span class="badge bg-success">
                                            Finalizado
                                        </span>

                                    @elseif ($recorrido->estado == 'Cancelado')

                                        <span class="badge bg-danger">
                                            Cancelado
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Desconocido
                                        </span>

                                    @endif
                                </td>

                                {{-- Acciones --}}
                                <td>
                                    <div class="d-flex flex-wrap gap-2">

                                        {{-- Ver --}}
                                        <a href="{{ route('recorridos.show', $recorrido->id_recorrido) }}"
                                           class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                            Ver
                                        </a>

                                        {{-- Editar --}}
                                        <a href="{{ route('recorridos.edit', $recorrido->id_recorrido) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                            Editar
                                        </a>

                                        {{-- Eliminar --}}
                                        <form action="{{ route('recorridos.destroy', $recorrido->id_recorrido) }}"
                                              method="POST"
                                              onsubmit="return confirm('¿Está seguro de eliminar este recorrido?');">

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
                                <td colspan="8" class="text-center py-4">
                                    <i class="bi bi-info-circle me-1"></i>
                                    No hay recorridos registrados.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Paginación --}}
            <div class="mt-3">
                {{ $recorridos->links() }}
            </div>

        </div>
    </div>

    {{-- Regresar --}}
    <div class="mt-3">
        <a href="{{ url('/') }}" class="btn btn-secondary">
            <i class="bi bi-house-door me-1"></i>
            Volver al inicio
        </a>
    </div>

</div>

@endsection
