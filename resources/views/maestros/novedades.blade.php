@extends('layouts.nav')

@section('sub-content')
<div>
    <h3>Novedades</h3>
    
    <div class="menu_maestros" id="menu_maestros">
        @foreach(auth()->user()->role->task as $permiso)
            @if($permiso->task == 'maestros/nueva_relacion')
                <a href="{{ route('nueva_relacion') }}" class="btn boton_principal" id="nuevo">Agregar</a>
            @endif
        @endforeach
        @foreach(auth()->user()->role->task as $permiso)
            @if($permiso->task == 'maestros/eliminar_relacion')
            <form action="{{ route('eliminar_relacion') }}" method="POST">
                @csrf
                <input type="hidden" name="code" id="cambiar_estado_input">
                <button class=" btn display_none btn-danger font-weight-bold" id="cambiar_estado" type="submit">Eliminar</button>
            </form>
            @endif
        @endforeach
        
    </div>
    @if(auth()->user()->role->role != 'superadmin')
    <p><strong>Para agregar una nueva novedad contactar a MR y Asociados</strong></p>
    @endif
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
    @forelse($novedades as $novedad)
    <tr>
        <td>{{ $novedad->code }}</td>
        <td>{{ $novedad->description }}</td>
        <td>{{ $novedad->unit }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="3" class="text-center">No se cargaron datos</td>
    </tr>
    @endforelse
    </tbody>
</table>
<script type="text/javascript" src="{{ URL::asset('js/maestros.js') }}"></script>
{{ $novedades->links()}}
@endsection