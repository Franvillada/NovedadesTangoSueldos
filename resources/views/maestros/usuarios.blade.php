@extends('layouts.nav')

@section('sub-content')
<div>
        <h3>Usuarios</h3>
    </div>
    
    <div class="menu_maestros" id="menu_maestros">
        @foreach(auth()->user()->role->task as $permiso)
            @if($permiso->task == 'maestros/nuevo_usuario')
                <a href="{{ route('nuevo_usuario') }}" class="btn boton_principal" id="nuevo">Nuevo</a>
            @endif
        @endforeach
        @foreach(auth()->user()->role->task as $permiso)
            @if($permiso->task == 'maestros/editar_usuario')
            <form action="{{ route('editar_usuario') }}" method="GET">
                @csrf
                <input type="hidden" name="email" id="editar_input">
                <button class=" btn boton_principal display_none" id="editar" type="submit">Editar</button>
            </form>
            @endif
        @endforeach
        @foreach(auth()->user()->role->task as $permiso)
            @if($permiso->task == 'maestros/cambiar_estado_usuario')
            <form action="{{ route('cambiar_estado_usuario') }}" method="POST">
                @csrf
                <input type="hidden" name="email" id="cambiar_estado_input">
                <button class=" btn display_none font-weight-bold" id="cambiar_estado" type="submit"></button>
            </form>
            @endif
        @endforeach
    </div>

    <table class="table" id="table">
        <thead>
            <tr>
            <th scope="col">Email</th>
            <th scope="col">Nombre de Usuario</th>
            <th scope="col">Rol</th>
            <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
        <tr>
            <td>{{ $user->email }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->role->role }}</td>
            <td>{{ ($user->active) ? 'Habilitado' : 'Inhabilitado' }}</td>
        </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No se cargaron datos</td>
            </tr>
        @endforelse
        </tbody>
</table>
<script type="text/javascript" src="{{ URL::asset('js/maestros.js') }}"></script>
{{ $users->links() }}
@endsection