@extends('backend.index')

@section('sub-content')
    <div>
        <h3>Clientes</h3>
    </div>
    
    <div class="menu_maestros" id="menu_maestros">
        <a href="{{ route('nuevo_cliente') }}" class="btn boton_principal" id="nuevo">Nuevo</a>
        <form action="{{ route('importar_clientes') }}" method="post" class="importar" enctype="multipart/form-data">
            @csrf
            <label for="file" class="btn boton_principal mb-0">
                Importar
            </label>
            <input id="file" name="file" type="file" class="d-none" onchange="form.submit()"/>
        </form>
        <form action="{{ route('editar_cliente') }}" method="GET">
            @csrf
            <input type="hidden" name="business_name" id="editar_input">
            <button class=" btn boton_principal display_none" id="editar" type="submit">Editar</button>
        </form>
        <form action="{{ route('cambiar_estado_cliente') }}" method="POST">
            @csrf
            <input type="hidden" name="business_name" id="cambiar_estado_input">
            <button class=" btn display_none font-weight-bold" id="cambiar_estado" type="submit"></button>
        </form>
        
    </div>

    <table class="table" id="table">
        <thead>
            <tr>
            <th scope="col">Razon Social</th>
            <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $cliente)
            <tr>
                <td>{{ $cliente->business_name }}</td>
                <td>{{ ($cliente->active) ? 'Habilitado' : 'Inhabilitado' }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No se cargaron datos</td>
                </tr>
            @endforelse
        </tbody>
</table>
<script type="text/javascript" src="{{ URL::asset('js/maestros.js') }}"></script>
{{ $clientes->links() }}
@endsection