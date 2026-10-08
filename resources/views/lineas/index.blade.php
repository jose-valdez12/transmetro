@extends('layouts.app')

@section('title', 'Líneas')

@section('content')

    <h2>Líneas de transporte</h2>

    @if (session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif

    <a href="{{ route('lineas.create') }}">
        Registrar nueva línea
    </a>

    <br><br>

    @if ($lineas->count() > 0)

        <table border="3" cellpadding="8" cellspacing="0">

            <thead>
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

                @foreach ($lineas as $linea)

                    <tr>
                        <td>{{ $linea->id_linea }}</td>

                        <td>{{ $linea->nombre }}</td>

                        <td>{{ $linea->distancia_total }} km</td>

                        <td>
                            {{ $linea->municipio->nombre ?? 'Sin municipio' }}
                        </td>

                        <td>
                            @if ($linea->estado)
                                Activo
                            @else
                                Inactivo
                            @endif
                        </td>

                        <td>

                            <a href="{{ route('lineas.show', $linea->id_linea) }}">
                                Ver
                            </a>

                            |

                            <a href="{{ route('lineas.edit', $linea->id_linea) }}">
                                Editar
                            </a>

                            |

                            <form action="{{ route('lineas.destroy', $linea->id_linea) }}"
                                  method="POST"
                                  style="display:inline;">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        onclick="return confirm('¿Está seguro de eliminar esta línea?')">
                                    Eliminar
                                </button>

                            </form>

                        </td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    @else

        <p>No hay líneas registradas.</p>

    @endif

    <br>

    <a href="{{ route('municipios.index') }}">
        Ir a Municipios
    </a><br>
    <a href="{{ url('/') }}">
        Volver al inicio
    </a>

@endsection
