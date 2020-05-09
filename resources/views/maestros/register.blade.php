@extends('layouts.nav')

@section('sub-content')
<div>
    <h3>Maestros - Usuarios</h3>
    <h6>Nuevo Usuario</h6>
</div>

<form action="" method="POST" class="maestros_form">
    @csrf
    <div class="form-group accept_cancel_button">
        <button class="btn btn-success" type="submit">Aceptar</button>
        <button class="btn btn-danger" type="submit">Cancelar</button>
    </div>
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
        <select name="role" id="role" class="form-control">
            <option value="admin">Administrador</option>
            <option value="general">Usuario General</option>
            @if(auth()->user()->role->role == 'superadmin')
            <option value="superadmin">Sueperadmin</option>
            @endif
        </select>        
    </div>
    
</form>
@endsection
