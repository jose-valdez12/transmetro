
@extends('layouts.app')

@section('title', 'Líneas')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Líneas de transporte</h2>

        <a href="{{ route('lineas.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Registrar nueva línea
        </a>
    </div>

    {{-- Mensaje de confirmación --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabla de líneas --}}
    <div class="card">
        <div class="card-header">
            Listado de líneas de transporte
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Distancia total</th>
                            <th>Municipio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($lineas as $linea)
                            <tr>
                                <td>{{ $linea->id_linea }}</td>

                                <td>{{ $linea->nombre }}</td>

                                <td>{{ $linea->distancia_total }} km</td>

                                <td>
                                    {{ $linea->municipio->nombre ?? 'Sin municipio' }}
                                </td>

                                <td>
                                    @if ($linea->estado)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('lineas.show', $linea->id_linea) }}"
                                       class="btn btn-info btn-sm">
                                        Ver
                                    </a>

                                    <a href="{{ route('lineas.edit', $linea->id_linea) }}"
                                       class="btn btn-warning btn-sm">
                                        Editar
                                    </a>

                                    <form action="{{ route('lineas.destroy', $linea->id_linea) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('¿Está seguro de eliminar esta línea?');">

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
                                    No hay líneas registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <div class="mt-3 d-flex gap-2">
        <a href="{{ route('municipios.index') }}" class="btn btn-outline-primary">
            <i class="bi bi-geo-alt me-1"></i>
            Ir a Municipios
        </a>

        <a href="{{ url('/') }}" class="btn btn-secondary">
            <i class="bi bi-house-door me-1"></i>
            Volver al inicio
        </a>
    </div>

</div>

@endsection

