
@extends('layouts.app')


@section('title', 'Municipios')

@section('content')
    <h2>Gestión de municipios</h2>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <p>
        <a href="{{ route('municipios.create') }}">Registrar municipio</a>
    </p>

    <table border="3" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Departamento</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($municipios as $municipios)
                <tr>
                    <td>{{ $municipios->id_municipio }}</td>
                    <td>{{ $municipios->nombre }}</td>
                    <td>{{ $municipios->estado ? 'Activo' : 'Inactivo' }}</td>
                    <td>{{ $municipios->departamento }}</td>
                    <td>
                        <a href="{{ route('municipios.show', $municipios) }}">Ver</a>
                        |
                        <a href="{{ route('municipios.edit', $municipios) }}">Editar</a>
                        |
                        <form action="{{ route('municipios.destroy', $municipios) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    onclick="return confirm('¿Seguro que deseas eliminar este municipio?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay municipios registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p><a href="{{ url('/') }}">Volver al inicio</a></p>
@endsection
