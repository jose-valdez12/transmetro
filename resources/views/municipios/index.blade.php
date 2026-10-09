
@extends('layouts.app')

@section('title', 'Municipios')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de municipios</h2>

        <a href="{{ route('municipios.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Registrar municipio
        </a>
    </div>

    {{-- Mensaje de confirmación --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabla de municipios --}}
    <div class="card">
        <div class="card-header">
            Listado de municipios registrados
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Departamento</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($municipios as $municipio)
                            <tr>
                                <td>{{ $municipio->id_municipio }}</td>

                                <td>{{ $municipio->nombre }}</td>

                                <td>{{ $municipio->departamento }}</td>

                                <td>
                                    @if ($municipio->estado)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('municipios.show', $municipio) }}"
                                       class="btn btn-info btn-sm">
                                        Ver
                                    </a>

                                    <a href="{{ route('municipios.edit', $municipio) }}"
                                       class="btn btn-warning btn-sm">
                                        Editar
                                    </a>

                                    <form action="{{ route('municipios.destroy', $municipio) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar este municipio?');">

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
                                <td colspan="5" class="text-center">
                                    No hay municipios registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <a href="{{ url('/') }}" class="btn btn-secondary mt-3">
        <i class="bi bi-arrow-left me-1"></i>
        Volver al inicio
    </a>

</div>

@endsection

