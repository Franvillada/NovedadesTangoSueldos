@extends('layouts.nav')

@section('sub-content')
    <div>
        <h3>Registro Novedades</h3>
    </div>
    
    <div class="menu_maestros" id="menu_maestros">
        <a href="{{ route('nuevo_registro') }}" class="btn boton_principal" id="nuevo">Nuevo</a>
        <form action="{{ route('editar_registro') }}" method="GET">
            @csrf
            <input type="hidden" name="registro_id" id="editar_input">
            <button class="btn boton_principal display_none" id="editar" type="submit">Editar</button>
        </form>
        <form action="{{ route('cambiar_estado_registro') }}" method="POST">
            @csrf
            <input type="hidden" name="registro_id" id="cambiar_estado_input">
            <button class="btn display_none font-weight-bold" id="cambiar_estado" type="submit"></button>
        </form>
        <form action="{{ route('eliminar_registro') }}" method="POST">
            @csrf
            <input type="hidden" name="registro_id" id="eliminar_input">
            <button class="btn display_none btn-danger font-weight-bold" id="eliminar" type="submit">Eliminar</button>
        </form>
    </div>

    <table class="table" id="table">
        <thead>
            <tr>
            <th scope="col" class="d-none">ID</th>
            <th scope="col">Legajo</th>
            <th scope="col">Nombre</th>
            <th scope="col">Codigo Novedad</th>
            <th scope="col">Descripcion Novedad</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Fecha</th>
            <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registros as $registro)
            <tr>
                <td class="d-none">{{ $registro->id }}</td>
                <td>{{ $registro->employee_number }}</td>
                <td>{{ $registro->name }}</td>
                <td>{{ $registro->code }}</td>
                <td>{{ $registro->description }}</td>
                <td>{{ $registro->quantity }}</td>
                <td>{{ $registro->date }}</td>
                <td>{{ ($registro->informed == 1) ? 'Informado' : 'Abierto' }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No se cargo ningun legajo al sistema</td>
                </tr>
            @endforelse
        </tbody>
</table>
<script type="text/javascript" src="{{ URL::asset('js/maestros.js') }}"></script>
@endsection