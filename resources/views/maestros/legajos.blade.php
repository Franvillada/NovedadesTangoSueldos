@extends('layouts.nav')

@section('sub-content')
    <div>
        <h3>Maestros - Legajos</h3>
    </div>
    
    <div class="menu">
        <a href="" class="btn btn-success">Nuevo</a>
        <a href="">Editar</a>
    </div>

    <table class="table">
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