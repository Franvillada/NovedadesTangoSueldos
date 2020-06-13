@extends('backend.index')

@section('sub-content')
    <div>
        <h3>Nueva Novedad</h3>
    </div>

    <form action="" method="POST" class="maestros_form">
        @csrf
        <div class="form-group accept_cancel_button">
            <button class="btn btn-success" type="submit">Aceptar</button>
            <button class="btn btn-danger" type="submit">Cancelar</button>
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
        
    </form>

@endsection