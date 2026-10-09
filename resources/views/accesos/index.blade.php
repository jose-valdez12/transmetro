
@extends('layouts.app')

@section('title', 'Accesos')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de accesos</h2>

        <a href="{{ route('accesos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Crear acceso
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            Listado de accesos registrados
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Estación</th>
                            <th>Municipio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($accesos as $acceso)
                            <tr>
                                <td>{{ $acceso->id_acceso }}</td>

                                <td>{{ $acceso->nombre }}</td>

                                <td>
                                    {{ $acceso->estacion->nombre ?? 'Sin estación' }}
                                </td>

                                <td>
                                    {{ $acceso->estacion->municipio->nombre ?? 'Sin municipio' }}
                                </td>

                                <td>
                                    @if ($acceso->estado)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('accesos.show', $acceso->id_acceso) }}"
                                       class="btn btn-info btn-sm">
                                        Ver
                                    </a>

                                    <a href="{{ route('accesos.edit', $acceso->id_acceso) }}"
                                       class="btn btn-warning btn-sm">
                                        Editar
                                    </a>

                                    <form action="{{ route('accesos.destroy', $acceso->id_acceso) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('¿Deseas eliminar este acceso?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    No hay accesos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="mt-3">
                {{ $accesos->links() }}
            </div>

        </div>
    </div>

    <a href="{{ url('/') }}" class="btn btn-secondary mt-3">
        <i class="bi bi-house-door me-1"></i>
        Volver al inicio
    </a>

</div>

@endsection

