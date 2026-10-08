@extends('layouts.app')

@section('title', 'Estaciones')

@section('content')

<div class="container">

    <h1>Estaciones</h1>

    <a href="{{ route('estaciones.create') }}" class="btn btn-primary mb-3">
        Crear Estación
    </a>

    @if (session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif



    <table class="table">
        <table border="3" cellpadding="8" cellspacing="0">

        <thead>
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

            @foreach ($estaciones as $estacion)

                <tr>

                    <td>
                        {{ $estacion->id_estacion }}
                    </td>

                    <td>
                        {{ $estacion->nombre }}
                    </td>

                    <td>
                        {{ $estacion->direccion }}
                    </td>

                    <td>
                        {{ $estacion->municipio->nombre ?? 'Sin municipio' }}
                    </td>

                    <td>
                        @if ($estacion->estado)
                            Activo
                        @else
                            Inactivo
                        @endif
                    </td>

                    <td>

                        <a href="{{ route('estaciones.show', $estacion->id_estacion) }}"
                           class="btn btn-info">
                            Ver
                        </a>

                        <a href="{{ route('estaciones.edit', $estacion->id_estacion) }}"
                           class="btn btn-warning">
                            Editar
                        </a>

                        <form action="{{ route('estaciones.destroy', $estacion->id_estacion) }}"
                              method="POST"
                              style="display:inline-block;">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger"
                                    onclick="return confirm('¿Está seguro de eliminar esta estación?')">
                                Eliminar
                            </button>

                        </form>

                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</div>

<a href="{{ url('/') }}">Volver al inicio</a>

@endsection
