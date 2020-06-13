@extends('backend.index')

@section('sub-content')
    <div>
        <h3>Novedades</h3>
    </div>
    
    <div class="menu_maestros" id="menu_maestros">
        <a href="{{ route('nueva_novedad') }}" class="btn boton_principal" id="nuevo">Nuevo</a>
        <form action="{{ route('importar_novedades') }}" method="post" class="importar" enctype="multipart/form-data">
            @csrf
            <label for="file" class="btn boton_principal mb-0">
                Importar
            </label>
            <input id="file" name="file" type="file" class="d-none" onchange="form.submit()"/>
        </form>
        <form action="{{ route('editar_novedad') }}" method="GET">
            @csrf
            <input type="hidden" name="code" id="editar_input">
            <button class=" btn boton_principal display_none" id="editar" type="submit">Editar</button>
        </form>
        <form action="{{ route('cambiar_estado_novedad') }}" method="POST">
            @csrf
            <input type="hidden" name="code" id="cambiar_estado_input">
            <button class=" btn display_none font-weight-bold" id="cambiar_estado" type="submit"></button>
        </form>
        
    </div>

    <table class="table" id="table">
        <thead>
            <tr>
            <th scope="col">Codigo</th>
            <th scope="col">Descripción</th>
            <th scope="col">Unidad</th>
            <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($novedades as $novedad)
            <tr>
                <td>{{ $novedad->code }}</td>
                <td>{{ $novedad->description }}</td>
                <td>{{ $novedad->unit }}</td>
                <td>{{ ($novedad->active) ? 'Habilitado' : 'Inhabilitado' }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No se cargo ninguna novedad al sistema</td>
                </tr>
            @endforelse
        </tbody>
</table>
<script type="text/javascript" src="{{ URL::asset('js/maestros.js') }}"></script>
{{ $novedades->links() }}
@endsection