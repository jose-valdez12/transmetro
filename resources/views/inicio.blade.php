@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    <h2>Bienvenido al sistema</h2>

    <p>
        Sistema web para la gestión y control del transporte público.
    </p>

    <p>
        Desde este sistema se administrarán las líneas, estaciones,
        buses, pilotos, guardias, recorridos y demás información
        relacionada con el servicio de transporte.
    </p>


    <p>
        <a href="{{ route('municipios.index') }}">Gestión de municipios</a>
    </p>
    <p>
        <a href="{{ route('lineas.index') }}">Gestión de líneas</a>
    </p>

    <p>
        <a href="{{ route('estaciones.index') }}">Gestión de estaciones</a>
    </p>

@endsection
