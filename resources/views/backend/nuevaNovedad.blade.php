@extends('backend.index')

@section('sub-content')
    <div>
        <h3>Nueva Novedad</h3>
    </div>

    <form action="" method="POST" class="maestros_form_usuarios">
        @csrf
        <div class="form-group accept_cancel_button">
            <button class="btn btn-success" type="submit">Aceptar</button>
            <a href="{{ route('backend_novedades') }}" class="btn btn-danger">Cancelar</a>
        </div>
        <div class="form-group">
            <label for="code">Codigo:</label>
            <input  class="form-control" 
                    type="text" 
                    name="code" 
                    id="code"
                    value="{{ old('code') }}">
            <div class="{{ $errors->has('code') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('code', '<span>:message</span>') !!}
            </div>
        </div>

        <div class="form-group">
            <label for="description">Descripción:</label>
            <input  class="form-control" 
                    type="text" 
                    name="description" 
                    id="description"
                    value="{{ old('description') }}">
            <div class="{{ $errors->has('description') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('description', '<span>:message</span>') !!}
            </div>
        </div>
        
        <div class="form-group">
            <label for="unit">Unidad:</label>
            <input  class="form-control" 
                    type="text" 
                    name="unit" 
                    id="unit" >
            <div class="{{ $errors->has('unit') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('unit', '<span>:message</span>') !!}
            </div>
        </div>

        <div class="form-group">
            <p>Categoria:</p>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="ausentismo" value="absence">
                <label class="form-check-label" for="ausentismo">
                    Ausentismo
                </label>
            </div>
            <div class="form-check">   
                <input class="form-check-input" type="checkbox" name="accidente_laboral" value="work_accident">
                <label class="form-check-label" for="accidente_laboral">
                    Accidente Laboral
                </label> 
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="vacacion" value="vacations">
                <label class="form-check-label" for="vacaciones">
                    Vacaciones
                </label>
            </div>
        </div>
        
    </form>

@endsection