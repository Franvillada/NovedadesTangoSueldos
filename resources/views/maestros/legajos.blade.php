@extends('layouts.nav')

@section('sub-content')
    <div>
        <h3>Maestros - Legajos</h3>
    </div>
    
    <div class="menu_maestros" id="menu_maestros">
        <a href="{{ route('nuevo_legajo') }}" class="btn btn-success" id="nuevo">Nuevo</a>
        <form action="{{ route('editar_legajo') }}" method="GET">
            @csrf
            <input type="hidden" name="legajo" id="editar_input">
            <button class=" btn btn-success display_none" id="editar" type="submit">Editar</button>
        </form>
        <form action="{{ route('cambiar_estado_legajo') }}" method="POST">
            @csrf
            <input type="hidden" name="legajo" id="cambiar_estado_input">
            <button class=" btn display_none" id="cambiar_estado" type="submit"></button>
        </form>
    </div>

    <table class="table" id="table">
        <thead>
            <tr>
            <th scope="col">Legajo</th>
            <th scope="col">Nombre</th>
            <th scope="col">Ingreso</th>
            <th scope="col">Egreso</th>
            <th scope="col">Vacaciones</th>
            <th scope="col">Scoring</th>
            <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
        @if($empleados!= NULL)
            @foreach($empleados as $empleado)
            <tr>
                <td>{{ $empleado->employee_number }}</td>
                <td>{{ $empleado->name }}</td>
                <td>{{ $empleado->entry_date }}</td>
                <td>{{ $empleado->leave_date }}</td>
                <td>{{ $empleado->vacations }}</td>
                <td>{{ $empleado->scoring }}</td>
                <td>{{ ($empleado->active) ? 'Habilitado' : 'Inhabilitado' }}</td>
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
{{ $empleados->links() }}
@endsection