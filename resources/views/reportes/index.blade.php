
@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h2 class="fw-bold">
        <i class="bi bi-file-earmark-bar-graph me-2"></i>
        Gestión de Reportes
    </h2>

    <p class="text-muted">
        Consulte y genere reportes de la información
        registrada en el sistema Transmetro.
    </p>

    <div class="alert alert-info">
        Módulo de Reportes creado correctamente.
    </div>
<a href="{{ route('reportes.buses') }}"
   class="btn btn-primary">
    <i class="bi bi-bus-front me-2"></i>
    Ver reporte de buses
</a>
<a href="{{ route('reportes.recorridos') }}"
   class="btn btn-primary">
    <i class="bi bi-signpost-split me-2"></i>
    Ver reporte de recorridos
</a>
<a href="{{ route('reportes.pilotos') }}"
   class="btn btn-primary">
    <i class="bi bi-person-badge me-2"></i>
    Ver reporte de pilotos
</a>
<a href="{{ route('reportes.guardias') }}"
   class="btn btn-primary">
    <i class="bi bi-shield-check me-2"></i>
    Ver reporte de guardias
</a>
<a href="{{ route('reportes.estaciones') }}"
   class="btn btn-primary">
    <i class="bi bi-building me-2"></i>
    Ver reporte de estaciones
</a><br>

<br><a href="{{ route('reportes.alertas') }}"
   class="btn btn-primary">
    <i class="bi bi-exclamation-triangle me-2"></i>
    Ver reporte de alertas
</a>
<a href="{{ route('reportes.municipios') }}"
   class="btn btn-primary">
    <i class="bi bi-geo-alt me-2"></i>
    Ver reporte de municipios
</a>
<a href="{{ route('reportes.lineas') }}"
   class="btn btn-primary">
    <i class="bi bi-diagram-3 me-2"></i>
    Ver reporte de líneas
</a>
<a href="{{ route('reportes.parqueos') }}"
   class="btn btn-primary">
    <i class="bi bi-p-square me-2"></i>
    Ver reporte de parqueos
</a>
</div>
@endsection
