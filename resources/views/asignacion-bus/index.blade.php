
@extends('layouts.app')

@section('title', 'Asignación de buses')

@section('content')
<div class="container-fluid">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Asignación de buses a líneas</h2>
            <p class="text-muted mb-0">
                Administración de los buses asignados a las líneas de transporte.
            </p>
        </div>

        <a href="{{ route('asignacion-bus.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Nueva asignación
        </a>
    </div>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar">
            </button>
        </div>
    @endif

    {{-- Tabla de asignaciones --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-bus-front me-2"></i>
            Listado de asignaciones registradas
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Bus</th>
                            <th>Línea</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha de fin</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($asignaciones as $asignacion)
                            <tr>
                                <td>{{ $asignacion->id_asignacion }}</td>

                                <td>
                                    {{ $asignacion->bus->codigo ?? 'Sin bus' }}
                                </td>

                                <td>
                                    {{ $asignacion->linea->nombre ?? 'Sin línea' }}
                                </td>

                              <td>
                                    {{ $asignacion->fecha_inicio? $asignacion->fecha_inicio->format('d/m/Y')  : '-' }}
                             </td>

                              <td>
                                    {{ $asignacion->fecha_fin ? $asignacion->fecha_fin->format('d/m/Y') : 'Sin fecha' }}
                                </td>

                                <td>
                                    @if ($asignacion->estado)
                                        <span class="badge bg-success">
                                            Activa
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            Inactiva
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex flex-wrap gap-2">

                                        {{-- Ver --}}
                                        <a href="{{ route('asignacion-bus.show', $asignacion->id_asignacion) }}"
                                           class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                            Ver
                                        </a>

                                        {{-- Editar --}}
                                        <a href="{{ route('asignacion-bus.edit', $asignacion->id_asignacion) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                            Editar
                                        </a>

                                        {{-- Eliminar --}}
                                        <form action="{{ route('asignacion-bus.destroy', $asignacion->id_asignacion) }}"
                                              method="POST"
                                              onsubmit="return confirm('¿Está seguro de eliminar esta asignación?');">

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
                                <td colspan="7" class="text-center py-4">
                                    No hay asignaciones registradas.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>

            </div>

            {{-- Paginación --}}
            <div class="mt-3">
                {{ $asignaciones->links() }}
            </div>

        </div>
    </div>

    {{-- Volver al inicio --}}
    <div class="mt-3">
        <a href="{{ url('/') }}" class="btn btn-secondary">
            <i class="bi bi-house-door me-1"></i>
            Volver al inicio
        </a>
    </div>

</div>
@endsection
