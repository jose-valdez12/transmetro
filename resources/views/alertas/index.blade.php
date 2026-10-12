
@extends('layouts.app')

@section('title', 'Gestión de Alertas')

@section('content')
<div class="container-fluid">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Gestión de Alertas</h2>
            <p class="text-muted mb-0">
                Registro y seguimiento de alertas del sistema de transporte.
            </p>
        </div>

        <a href="{{ route('alertas.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Nueva alerta
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

    {{-- Tabla de alertas --}}
    <div class="card shadow-sm">

        <div class="card-header">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Listado de alertas registradas
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tipo de alerta</th>
                            <th>Descripción</th>
                            <th>Recorrido</th>
                            <th>Estación</th>
                            <th>Fecha y hora</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($alertas as $alerta)

                            <tr>

                                <td>
                                    {{ $alerta->id_alerta }}
                                </td>

                                <td>
                                    <strong>{{ $alerta->tipo }}</strong>
                                </td>

                                <td>
                                    {{ \Illuminate\Support\Str::limit($alerta->descripcion, 70) }}
                                </td>

                                <td>
                                    @if ($alerta->recorrido)
                                        Recorrido #{{ $alerta->recorrido->id_recorrido }}
                                    @else
                                        <span class="text-muted">
                                            No asignado
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $alerta->estacion->nombre ?? 'No asignada' }}
                                </td>

                                <td>
                                    {{ $alerta->fecha_hora
                                        ? $alerta->fecha_hora->format('d/m/Y H:i')
                                        : 'Sin fecha' }}
                                </td>

                                <td>
                                    @if ($alerta->estado == 'Pendiente')
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-clock me-1"></i>
                                            Pendiente
                                        </span>
                                    @elseif ($alerta->estado == 'Atendida')
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Atendida
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            {{ $alerta->estado }}
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex flex-wrap gap-2">

                                        {{-- Ver --}}
                                        <a href="{{ route('alertas.show', $alerta->id_alerta) }}"
                                           class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                            Ver
                                        </a>

                                        {{-- Editar --}}
                                        <a href="{{ route('alertas.edit', $alerta->id_alerta) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                            Editar
                                        </a>

                                        {{-- Asignar Bus --}}
                                        <a href="{{ route('alertas.asignar-bus', $alerta->id_alerta) }}"
                                           class="btn btn-primary btn-sm">
                                            <i class="bi bi-bus-front"></i>
                                            Asignar Bus
                                        </a>

                                        {{-- Eliminar --}}
                                        <form action="{{ route('alertas.destroy', $alerta->id_alerta) }}"
                                              method="POST"
                                              onsubmit="return confirm('¿Está seguro de eliminar esta alerta?');">

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

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="bi bi-info-circle me-1"></i>
                                    No hay alertas registradas.
                                </td>
                            </tr>

                        @endforelse
                    </tbody>

                </table>

            </div>

            {{-- Paginación --}}
            <div class="mt-3">
                {{ $alertas->links() }}
            </div>

        </div>
    </div>

    {{-- Regresar --}}
    <div class="mt-3">
        <a href="{{ url('/') }}" class="btn btn-secondary">
            <i class="bi bi-house-door me-1"></i>
            Volver al inicio
        </a>
    </div>

</div>
@endsection
