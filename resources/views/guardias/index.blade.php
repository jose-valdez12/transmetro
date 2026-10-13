
@extends('layouts.app')

@section('title', 'Gestión de Guardias')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Gestión de Guardias</h2>
            <p class="text-muted mb-0">
                Administración del personal de seguridad de Transmetro.
            </p>
        </div>

        <a href="{{ route('guardias.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Nuevo guardia
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
            <i class="bi bi-shield-check me-2"></i>
            Listado de guardias
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($guardias as $guardia)
                            <tr>
                                <td>{{ $guardia->id_guardia }}</td>
                                <td>{{ $guardia->nombres }}</td>
                                <td>{{ $guardia->apellidos }}</td>
                                <td>{{ $guardia->telefono ?: 'No registrado' }}</td>

                                <td>
                                    @if($guardia->estado)
                                        <span class="badge bg-success">
                                            Activo
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex flex-wrap gap-2">

                                        <a href="{{ route('guardias.show', $guardia->id_guardia) }}"
                                           class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                            Ver
                                        </a>

                                        <a href="{{ route('guardias.edit', $guardia->id_guardia) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                            Editar
                                        </a>

                                        <form action="{{ route('guardias.destroy', $guardia->id_guardia) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar este guardia?');">
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
                                    No hay guardias registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $guardias->links() }}
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
