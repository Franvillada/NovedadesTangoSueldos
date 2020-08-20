@extends('layouts.nav')

@section('sub-content')
<div>
    <h3>Añadir Novedad</h3>

    <form action="" method="POST" class="maestros_form_novedades">
        @csrf
        <div class="form-group accept_cancel_button">
            <button class="btn btn-success" type="submit">Aceptar</button>
            <a href="{{ route('novedades') }}" class="btn btn-danger">Cancelar</a>
        </div>
        <div class="form-group añadir_novedad_group">
            <p class="mt-3"><strong>IMPORTANTE</strong>:Para hacer una seleccion multiple mantener presionado la tecla CTRL</p>
            <select name="novedades[]" id="novedades" class="form-control" multiple="multiple" size="10">
                @foreach($novedades_disponibles as $novedad)
                <option value="{{ $novedad->code }}">{{ $novedad->code}}: {{$novedad->description}}</option>
                @endforeach
            </select>
            <div class="{{ $errors->has('novedades') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('novedades', '<span>:message</span>') !!}
            </div> 
        </div>
    </form>
    
</div>
@endsection