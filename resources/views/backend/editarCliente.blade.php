@extends('backend.index')

@section('sub-content')
    <div>
        <h3>Clientes</h3>
        <h6>Editar Cliente</h6>
    </div>

    <div class="elegir_empresa mt-5">

        <form action="" method="POST">
            @csrf
            <input type="hidden" name="old_business_name" value="{{ $cliente->business_name }}">
            <div class="form-group">
                <label for="business_name"><strong>Razon Social:</strong></label>
                <input  class="form-control" 
                        type="text" 
                        name="business_name" 
                        id="business_name"
                        value="{{ $cliente->business_name }}"
                        placeholder="">
                <div class="{{ $errors->has('business_name') ? 'alert alert-danger' : '' }}">
                    {!! $errors->first('business_name', '<span>:message</span>') !!}
                </div>
            </div>
            
            <div class="form-group accept_cancel_button">
                <button class="btn btn-success" type="submit">Aceptar</button>
                <a href="{{ url()->previous() }}" class="btn btn-danger">Cancelar</a>
            </div>
            
        </form>
    </div>

@endsection