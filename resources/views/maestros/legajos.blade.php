@extends('layouts.nav')

@section('sub-content')
    <div>
        <h3>Maestros - Legajos</h3>
    </div>
    
    <div class="menu">
        <a href="{{ route('nuevo_legajo') }}" class="btn btn-success" id="nuevo_legajo">Nuevo</a>
        <form action="{{ route('editar_legajo') }}" method="GET" class='editar_legajo'>
            @csrf
            <input type="hidden" name="legajo" id="legajo">
            <button class=" btn btn-success display_none" id="editar_legajo" type="submit">Editar</button>
        </form>
        <form action="{{ route('eliminar_legajo') }}" method="POST" class="eliminar_legajo">
            @csrf
            <button class=" btn btn-danger display_none" id="eliminar_legajo" type="submit">Eliminar</button>
        </form>
    </div>

    <table class="table" id="legajo_table">
        <thead>
            <tr>
            <th scope="col">Legajo</th>
            <th scope="col">Nombre</th>
            <th scope="col">Ingreso</th>
            <th scope="col">Egreso</th>
            <th scope="col">Vacaciones</th>
            <th scope="col">Scoring</th>
            <th scope="col">Activo</th>
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
                <td>{{ $empleado->active }}</td>
            </tr>
            @endforeach
        @else
            <tr>
                <td>No se cargo ningun legajo al sistema</td>
            </tr>
        @endif
        </tbody>
</table>
@endsection