
@extends('layouts.app')

@section('title', 'Accesos')

@section('content')

<div class="container">

    <h1>Accesos</h1>

    <a href="{{ route('accesos.create') }}" class="btn btn-primary mb-3">
        Crear Acceso
    </a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table border="3" cellpadding="8" cellspacing="0">

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

    <a href="{{ url('/') }}" class="btn btn-secondary mt-2">
        Regresar al inicio
    </a>

</div>

@endsection

