
@extends('layouts.app')

@section('title', 'Estaciones')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de estaciones</h2>

        <a href="{{ route('estaciones.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Crear estación
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            Listado de estaciones registradas
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Municipio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($estaciones as $estacion)
                            <tr>
                                <td>{{ $estacion->id_estacion }}</td>

                                <td>{{ $estacion->nombre }}</td>

                                <td>{{ $estacion->direccion }}</td>

                                <td>
                                    {{ $estacion->municipio->nombre ?? 'Sin municipio' }}
                                </td>

                                <td>
                                    @if ($estacion->estado)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('estaciones.show', $estacion->id_estacion) }}"
                                       class="btn btn-info btn-sm">
                                        Ver
                                    </a>

                                    <a href="{{ route('estaciones.edit', $estacion->id_estacion) }}"
                                       class="btn btn-warning btn-sm">
                                        Editar
                                    </a>

                                    <form action="{{ route('estaciones.destroy', $estacion->id_estacion) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('¿Está seguro de eliminar esta estación?');">

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
                                    No hay estaciones registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            @if (method_exists($estaciones, 'links'))
                <div class="mt-3">
                    {{ $estaciones->links() }}
                </div>
            @endif

        </div>
    </div>

    <a href="{{ url('/') }}" class="btn btn-secondary mt-3">
        <i class="bi bi-house-door me-1"></i>
        Volver al inicio
    </a>

</div>

@endsection

