@extends('backend.index')

@section('sub-content')
    <div>
        <h3>Nuevo Cliente</h3>
    </div>

    <div class="elegir_empresa mt-5">

        <form action="" method="POST">
            @csrf
            <div class="form-group">
                <label for="business_name"><strong>Cual es la Razon Social:</strong></label>
                <input  class="form-control" 
                        type="text" 
                        name="business_name" 
                        id="business_name"
                        value="{{ old('business_name') }}"
                        placeholder="">
                <div class="{{ $errors->has('business_name') ? 'alert alert-danger' : '' }}">
                    {!! $errors->first('business_name', '<span>:message</span>') !!}
                </div>
            </div>
            
            <button type="submit" class="btn boton_principal">Crear Cliente</button>
        </form>
    </div>

@endsection