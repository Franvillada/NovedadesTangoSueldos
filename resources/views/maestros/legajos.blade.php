@extends('layouts.nav')

@section('sub-content')
    <div>
        <h3>Legajos</h3>
    </div>
    
    <div class="menu_maestros" id="menu_maestros">
        @foreach(auth()->user()->role->task as $permiso)
            @if($permiso->task == 'maestros/nuevo_legajo')
                <a href="{{ route('nuevo_legajo') }}" class="btn boton_principal" id="nuevo">Nuevo</a>
            @endif
        @endforeach

        @foreach(auth()->user()->role->task as $permiso)
            @if($permiso->task == 'maestros/importar_legajos')
            <form action="{{ route('importar_legajos') }}" method="post" class="importar" enctype="multipart/form-data">
                @csrf
                <label for="file" class="btn boton_principal mb-0">
                    Importar
                </label>
                <input id="file" name="file" type="file" class="d-none" onchange="form.submit()"/>
            </form>
            @endif
        @endforeach
        
        @foreach(auth()->user()->role->task as $permiso)
            @if($permiso->task == 'maestros/editar_legajo')
            <form action="{{ route('editar_legajo') }}" method="GET">
            @csrf
                <input type="hidden" name="legajo" id="editar_input">
                <button class=" btn boton_principal display_none" id="editar" type="submit">Editar</button>
            </form>
            @endif
        @endforeach
        
        @foreach(auth()->user()->role->task as $permiso)
            @if($permiso->task == 'maestros/cambiar_estado_legajo')
            <form action="{{ route('cambiar_estado_legajo') }}" method="POST">
            @csrf
                <input type="hidden" name="legajo" id="cambiar_estado_input">
                <button class=" btn display_none font-weight-bold" id="cambiar_estado" type="submit"></button>
            </form>
            @endif
        @endforeach
        
    </div>

    <table class="table" id="table">
        <thead>
            <tr>
            <th scope="col">Legajo</th>
            <th scope="col">Nombre</th>
            <th scope="col">Ingreso</th>
            <th scope="col">Vacaciones Gozadas</th>
            <th scope="col">Saldo de Vacaciones</th>
            <th scope="col">Scoring</th>
            <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($empleados as $empleado)
            <tr>
                <td>{{ $empleado->employee_number }}</td>
                <td>{{ $empleado->name }}</td>
                <td>{{ $empleado->entry_date }}</td>
                <td>{{ $vacacionesGozadas[$empleado->employee_number] }}</td>
                <td>{{ $empleado->vacations - $vacacionesGozadas[$empleado->employee_number]}}</td>
                <td>{{ $empleado->scoring }}</td>
                <td>{{ ($empleado->active) ? 'Habilitado' : 'Inhabilitado' }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No se cargo ningun legajo al sistema</td>
                </tr>
            @endforelse
        </tbody>
</table>
<script type="text/javascript" src="{{ URL::asset('js/maestros.js') }}"></script>
{{ $empleados->links() }}
@endsection