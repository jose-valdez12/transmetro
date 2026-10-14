
@extends('layouts.app')

@section('title', 'Gestión de buses')

@section('content')
<div class="container-fluid">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Gestión de buses</h2>
            <p class="text-muted mb-0">
                Administración de los buses registrados en el sistema.
            </p>
        </div>

        <a href="{{ route('buses.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Registrar bus
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

    {{-- Tabla de buses --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-bus-front me-2"></i>
            Listado de buses registrados
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Capacidad máxima</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($buses as $bus)
                            <tr>
                                <td>{{ $bus->id_bus }}</td>

                                <td>{{ $bus->codigo }}</td>

                                <td>
                                    {{ $bus->capacidad_maxima }} pasajeros
                                </td>

                                <td>
                                    @switch($bus->estado)

                                        @case('Disponible')
                                            <span class="badge bg-success">
                                                Disponible
                                            </span>
                                            @break

                                        @case('Asignado')
                                            <span class="badge bg-primary">
                                                Asignado
                                            </span>
                                            @break

                                        @case('Mantenimiento')
                                            <span class="badge bg-warning text-dark">
                                                Mantenimiento
                                            </span>
                                            @break

                                        @case('Fuera de servicio')
                                            <span class="badge bg-danger">
                                                Fuera de servicio
                                            </span>
                                            @break

                                        @default
                                            <span class="badge bg-secondary">
                                                {{ $bus->estado }}
                                            </span>

                                    @endswitch
                                </td>

                                @if(auth()->user()->rol === 'Administrador')
                                <td>
                                    <div class="d-flex flex-wrap gap-2">

                                        {{-- Ver --}}
                                        <a href="{{ route('buses.show', $bus->id_bus) }}"
                                           class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                            Ver
                                        </a>

                                        {{-- Editar --}}
                                        <a href="{{ route('buses.edit', $bus->id_bus) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                            Editar
                                        </a>

                                        {{-- Eliminar --}}
                                        <form action="{{ route('buses.destroy', $bus->id_bus) }}"
                                              method="POST"
                                              onsubmit="return confirm('¿Está seguro de eliminar este bus?');">

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
                                @endif
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    No hay buses registrados.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- Paginación --}}
            <div class="mt-3">
                {{ $buses->links() }}
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
