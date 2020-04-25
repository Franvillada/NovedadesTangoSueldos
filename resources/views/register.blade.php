@extends('layouts.app')

@section('content')
<div class="headear text-center">
    <h1>Crear nuevo usuario:</h1>
</div>
<div clas="row mt-5">
    <div class="col-4 offset-4">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email con el que se registrara el usuario:</label>
                <input  class="form-control" 
                        type="email" 
                        name="email" 
                        id="email"
                        value="{{ old('email') }}"
                        placeholder="Email">
                <div class="{{ $errors->has('email') ? 'alert alert-danger' : '' }}">
                    {!! $errors->first('email', '<span>:message</span>') !!}
                </div>
            </div>

            <div class="form-group">
                <label for="username">Nombre de Usuario</label>
                <input  class="form-control" 
                        type="text" 
                        name="username" 
                        id="username"
                        value="{{ old('username') }}"
                        placeholder="Nombre de Usuario">
                <div class="{{ $errors->has('username') ? 'alert alert-danger' : '' }}">
                    {!! $errors->first('username', '<span>:message</span>') !!}
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña a utilizar:</label>
                <input  class="form-control" 
                        type="password" 
                        name="password" 
                        id="password" 
                        placeholder="Contraseña">
                <div class="{{ $errors->has('email') ? 'alert alert-danger' : '' }}">
                    {!! $errors->first('password', '<span>:message</span>') !!}
                </div>
            </div>
            <div class="form-group">
                <label for="password">Cual es el rol que se le asignara al usuario en el sistema?</label>
                <select name="role" id="role">
                    <option value="admin">Administrador</option>
                    <option value="parcial">Usuario General</option>
                </select>        
            </div>
            <button class="btn btn-primary btn-block" type="submit">Registrar</button>
        </form>
    </div>
    
</div> 
@endsection
