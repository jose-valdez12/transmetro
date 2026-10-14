
@extends('layouts.app')

@section('title', 'Visitas a Estaciones')

@section('content')
<div class="container-fluid">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Visitas a Estaciones</h2>
            <p class="text-muted mb-0">
                Registro y seguimiento de las visitas realizadas
                por los buses a las estaciones.
            </p>
        </div>

        <a href="{{ route('visitas.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Nueva visita
        </a>
    </div>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show"
             role="alert">

            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar">
            </button>
        </div>
    @endif

    {{-- Mensaje de error --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show"
             role="alert">

            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar">
            </button>
        </div>
    @endif

    {{-- Tabla de visitas --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-geo-alt me-2"></i>
            Listado de visitas registradas
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Recorrido</th>
                            <th>Bus</th>
                            <th>Línea</th>
                            <th>Estación</th>
                            <th>Fecha y hora de llegada</th>
                            <th>Fecha y hora de salida</th>
                            <th>Pasajeros</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($visitas as $visita)
                            <tr>

                                <td>
                                    {{ $visita->id_visita }}
                                </td>

                                <td>
                                    #{{ $visita->id_recorrido }}
                                </td>

                                <td>
                                    {{ $visita->recorrido->bus->codigo ?? 'Sin bus' }}
                                </td>

                                <td>
                                    {{ $visita->recorrido->linea->nombre ?? 'Sin línea' }}
                                </td>

                                <td>
                                    {{ $visita->estacion->nombre ?? 'Sin estación' }}
                                </td>

                                <td>
                                    {{ $visita->fecha_hora_llegada
                                        ? $visita->fecha_hora_llegada->format('d/m/Y H:i')
                                        : 'Sin registrar' }}
                                </td>

                                <td>
                                    {{ $visita->fecha_hora_salida
                                        ? $visita->fecha_hora_salida->format('d/m/Y H:i')
                                        : 'Sin registrar' }}
                                </td>

                                <td>
                                    <span class="badge bg-primary">
                                        {{ $visita->cantidad_pasajeros }}
                                    </span>
                                </td>
 @if(auth()->user()->rol === 'Administrador')
                                <td>
                                    <div class="d-flex flex-wrap gap-2">

                                        {{-- Ver --}}
                                        <a href="{{ route('visitas.show', $visita->id_visita) }}"
                                           class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                            Ver
                                        </a>

                                        {{-- Editar --}}
                                        <a href="{{ route('visitas.edit', $visita->id_visita) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                            Editar
                                        </a>

                                        {{-- Eliminar --}}
                                        <form action="{{ route('visitas.destroy', $visita->id_visita) }}"
                                              method="POST"
                                              onsubmit="return confirm('¿Está seguro de eliminar esta visita?');">

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
                                <td colspan="9" class="text-center py-4">
                                    <i class="bi bi-info-circle me-1"></i>
                                    No hay visitas registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

            {{-- Paginación --}}
            <div class="mt-3">
                {{ $visitas->links() }}
            </div>

        </div>
    </div>

    {{-- Volver al inicio --}}
    <div class="mt-3">
        <a href="{{ url('/') }}" class="btn btn-secondary">
            <i class="bi bi-house-door me-1"></i>
            Volver al inicio
        </a>
    </div>

</div>
@endsection
