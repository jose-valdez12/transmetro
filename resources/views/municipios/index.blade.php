
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

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Departamento</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($municipios as $municipio)
                <tr>
                    <td>{{ $municipio->id }}</td>
                    <td>{{ $municipio->nombre }}</td>
                    <td>{{ $municipio->departamento }}</td>
                    <td>
                        <a href="{{ route('municipios.show', $municipio) }}">Ver</a>
                        |
                        <a href="{{ route('municipios.edit', $municipio) }}">Editar</a>
                        |
                        <form action="{{ route('municipios.destroy', $municipio) }}"
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
