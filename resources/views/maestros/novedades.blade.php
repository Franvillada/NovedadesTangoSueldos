@extends('layouts.nav')

@section('sub-content')
<div>
    <h3>Maestros - Novedades</h3>
    <p><strong>Para agregar una nueva novedad contactar a MR y Asociados</strong></p>
    <p class="mt-5">Novedades en uso actualmente:</p>
</div>

<table class="table" id="table">
    <thead>
        <tr>
        <th scope="col">Codigo</th>
        <th scope="col">Descripción</th>
        <th scope="col">Unidad</th>
        </tr>
    </thead>
    <tbody>
    @if($novedades!= NULL)
        @foreach($novedades as $novedad)
        <tr>
            <td>{{ $novedad->code }}</td>
            <td>{{ $novedad->description }}</td>
            <td>{{ $novedad->unit }}</td>
        </tr>
        @endforeach
    @else
        <tr>
            <td>No se cargo ningun legajo al sistema</td>
        </tr>
    @endif
    </tbody>
</table>
<script type="text/javascript" src="{{ URL::asset('js/maestros.js') }}"></script>
@endsection