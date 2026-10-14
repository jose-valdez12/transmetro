
@extends('layouts.app')

@section('title', 'Gestión de Pilotos')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Gestión de Pilotos</h2>
            <p class="text-muted mb-0">
                Administración de los pilotos del sistema Transmetro.
            </p>
        </div>

        <a href="{{ route('pilotos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Nuevo piloto
        </a>

         <a class="btn btn-primary" href="{{url('/formacion-pilotos')}}">
            <i class="bi bi-plus-circle me-1"></i>
                        Formacion Pilotos
                    </a>

                    <a  class ="btn btn-primary" href="{{ route('asignaciones-pilotos.index') }}">
                        <i class="bi bi-plus-circle me-1"></i>
                      Asignación de Pilotos
                     </a>
    </div>

    {{-- Mensajes --}}
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

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-person-badge me-2"></i>
            Listado de pilotos registrados
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
                            <th>Dirección</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pilotos as $piloto)
                            <tr>
                                <td>{{ $piloto->id_piloto }}</td>
                                <td>{{ $piloto->nombres }}</td>
                                <td>{{ $piloto->apellidos }}</td>
                                <td>{{ $piloto->telefono ?? 'Sin teléfono' }}</td>
                                <td>{{ $piloto->direccion ?? 'Sin dirección' }}</td>

                                <td>
                                    @if($piloto->estado)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>
     @if(auth()->user()->rol === 'Administrador')
                                <td>
                                    <div class="d-flex flex-wrap gap-2">

                                        <a href="{{ route('pilotos.show', $piloto->id_piloto) }}"
                                           class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> Ver
                                        </a>

                                        <a href="{{ route('pilotos.edit', $piloto->id_piloto) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </a>

                                        <form action="{{ route('pilotos.destroy', $piloto->id_piloto) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar este piloto?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </button>
                                        </form>

                                    </div>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    No hay pilotos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pilotos->links() }}
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
