
@extends('layouts.app')

@section('title', 'Gestión de Parqueos')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Gestión de Parqueos</h2>
            <p class="text-muted mb-0">
                Administración de parqueos del sistema Transmetro.
            </p>
        </div>

        <a href="{{ route('parqueos.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Nuevo parqueo
        </a>
    </div>

    {{-- Mensajes de confirmación --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-p-square me-2"></i>
            Listado de parqueos
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Estado</th>
                            <th>Fecha de registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($parqueos as $parqueo)
                            <tr>
                                <td>{{ $parqueo->id_parqueo }}</td>

                                <td>
                                    <strong>{{ $parqueo->codigo }}</strong>
                                </td>

                                <td>
                                    @if($parqueo->estado == 'Disponible')
                                        <span class="badge bg-success">
                                            Disponible
                                        </span>
                                    @elseif($parqueo->estado == 'Ocupado')
                                        <span class="badge bg-danger">
                                            Ocupado
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            Mantenimiento
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $parqueo->created_at
                                        ? $parqueo->created_at->format('d/m/Y H:i')
                                        : 'Sin fecha' }}
                                </td>
@if(auth()->user()->rol === 'Administrador')
                                <td>
                                    <div class="d-flex flex-wrap gap-2">

                                        <a href="{{ route('parqueos.show', $parqueo->id_parqueo) }}"
                                           class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                            Ver
                                        </a>

                                        <a href="{{ route('parqueos.edit', $parqueo->id_parqueo) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                            Editar
                                        </a>

                                        <form action="{{ route('parqueos.destroy', $parqueo->id_parqueo) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('¿Está seguro de eliminar este parqueo?');">

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
                                <td colspan="5"
                                    class="text-center py-4">
                                    No hay parqueos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="mt-3">
                {{ $parqueos->links() }}
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
