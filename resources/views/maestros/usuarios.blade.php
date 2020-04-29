@extends('layouts.nav')

@section('sub-content')
<div>
        <h3>Maestros - Usuarios</h3>
    </div>
    
    <div class="menu_maestros" id="menu_maestros">
        <a href="{{ route('nuevo_usuario') }}" class="btn btn-success" id="nuevo">Nuevo</a>
        <form action="{{ route('editar_usuario') }}" method="GET" class='editar'>
            @csrf
            <input type="hidden" name="usuario" id="editar_input">
            <button class=" btn btn-success display_none" id="editar" type="submit">Editar</button>
        </form>
        <form action="{{ route('inhabilitar_usuario') }}" method="POST" class="inhabilitar">
            @csrf
            <input type="hidden" name="usuario" id="inhabilitar_input">
            <button class=" btn display_none" id="inhabilitar" type="submit"></button>
        </form>
    </div>

    <table class="table" id="table">
        <thead>
            <tr>
            <th scope="col">Nombre de Usuario</th>
            <th scope="col">Email</th>
            <th scope="col">Rol</th>
            <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
        @if($users!= NULL)
            @foreach($users as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role->role }}</td>
                <td>{{ ($user->active) ? 'Habilitado' : 'Inhabilitado' }}</td>
            </tr>
            @endforeach
        @else
            <tr>
                <td>No se cargo ningun usuario al sistema</td>
            </tr>
        @endif
        </tbody>
</table>
@endsection