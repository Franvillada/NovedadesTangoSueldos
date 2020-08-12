@extends('layouts.home')

@section('content')

<div class="login-form">
    <div class="col-3 offset-col-4-and-half">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input  class="form-control" 
                        type="email" 
                        name="email" 
                        id="email"
                        value="{{ old('email') }}"
                        >
                <div class="{{ $errors->has('email') ? 'alert alert-danger' : 'd-none' }}">
                    {!! $errors->first('email', '<span>:message</span>') !!}
                </div>    
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input  class="form-control" 
                        type="password" 
                        name="password" 
                        id="password" 
                        >
                <div class="{{ $errors->has('password') ? 'alert alert-danger' : 'd-none' }}">
                    {!! $errors->first('password', '<span>:message</span>') !!}
                </div>
            </div>
            <button class="btn boton_principal btn-block" type="submit">INGRESAR</button>
        </form>
    </div>
    
</div>

@endsection