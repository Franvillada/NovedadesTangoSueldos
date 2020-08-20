@extends('backend.index')

@section('sub-content')
<div>
        <h3>Usuarios</h3>
    </div>
    
    <div class="menu_maestros" id="menu_maestros">
        <a href="{{ route('nuevo_superadmin') }}" class="btn boton_principal" id="nuevo">Nuevo</a>
        <form action="{{ route('editar_superadmin') }}" method="GET">
            @csrf
            <input type="hidden" name="email" id="editar_input">
            <button class=" btn boton_principal display_none" id="editar" type="submit">Editar</button>
        </form>
        <form action="{{ route('cambiar_estado_usuario') }}" method="POST">
            @csrf
            <input type="hidden" name="email" id="cambiar_estado_input">
            <button class=" btn display_none font-weight-bold" id="cambiar_estado" type="submit"></button>
        </form>
    </div>

    <table class="table" id="table">
        <thead>
            <tr>
            <th scope="col">Email</th>
            <th scope="col">Nombre de Usuario</th>
            <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
        @forelse($usuarios as $usuario)
        <tr>
            <td>{{ $usuario->email }}</td>
            <td>{{ $usuario->username }}</td>
            <td>{{ ($usuario->active) ? 'Habilitado' : 'Inhabilitado' }}</td>
        </tr>
        @empty
            <tr>
                <td>No se cargaron datos</td>
            </tr>
        @endforelse
        </tbody>
</table>
<script type="text/javascript" src="{{ URL::asset('js/maestros.js') }}"></script>
{{ $usuarios->links() }}
@endsection