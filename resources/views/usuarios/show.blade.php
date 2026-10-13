
@extends('layouts.app')

@section('title', 'Detalles del Usuario')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <h2>Detalles del usuario</h2>
        <p class="text-muted">
            Información del usuario registrado en Transmetro.
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <i class="bi bi-person-badge me-2"></i>
            Usuario #{{ $usuario->id_usuario }}
        </div>

        <div class="card-body">

            <table class="table table-bordered align-middle">
                <tbody>

                    <tr>
                        <th style="width: 30%;">ID del usuario</th>
                        <td>{{ $usuario->id_usuario }}</td>
                    </tr>

                    <tr>
                        <th>Nombre completo</th>
                        <td>{{ $usuario->nombre }}</td>
                    </tr>

                    <tr>
                        <th>Correo electrónico</th>
                        <td>{{ $usuario->correo }}</td>
                    </tr>

                    <tr>
                        <th>Rol</th>
                        <td>
                            <span class="badge bg-primary">
                                {{ $usuario->rol }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Estado</th>
                        <td>
                            @if($usuario->estado)
                                <span class="badge bg-success">
                                    Activo
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    Inactivo
                                </span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Contraseña</th>
                        <td>
                            <span class="text-muted">
                                Protegida por seguridad
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Fecha de registro</th>
                        <td>
                            {{ $usuario->created_at
                                ? $usuario->created_at->format('d/m/Y H:i')
                                : 'Sin fecha' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Última actualización</th>
                        <td>
                            {{ $usuario->updated_at
                                ? $usuario->updated_at->format('d/m/Y H:i')
                                : 'Sin fecha' }}
                        </td>
                    </tr>

                </tbody>
            </table>

            <div class="d-flex flex-wrap gap-2 mt-3">

                <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}"
                   class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i>
                    Editar
                </a>

                <a href="{{ route('usuarios.index') }}"
                   class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Volver al listado
                </a>

            </div>

        </div>
    </div>

</div>
@endsection
