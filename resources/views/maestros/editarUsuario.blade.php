@extends('layouts.nav')

@section('sub-content')
<div>
    <h3>Editar Usuario</h3>
</div>

<form action="{{ route('editar_usuario') }}" method="POST" class="maestros_form_usuarios">
    @csrf
    <div class="form-group accept_cancel_button">
        <button class="btn btn-success" type="submit">Aceptar</button>
        <a href="{{ url()->previous() }}" class="btn btn-danger">Cancelar</a>
    </div>
    <input type="hidden" name="old_email" value="{{ $user->email }} ">
    <div class="form-group">
        <label for="email">Email:</label>
        <input  class="form-control" 
                type="email" 
                name="email" 
                id="email"
                value="{{ $user->email }}"
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
                value="{{ $user->username }}"
                placeholder="Nombre de Usuario">
        <div class="{{ $errors->has('username') ? 'alert alert-danger' : '' }}">
            {!! $errors->first('username', '<span>:message</span>') !!}
        </div>
    </div>
    
    <div class="form-group">
        <label for="password">Contraseña:</label>
        <input  class="form-control" 
                type="password" 
                name="password" 
                id="password"
                value="***********" disabled>
        <div class="{{ $errors->has('email') ? 'alert alert-danger' : '' }}">
            {!! $errors->first('password', '<span>:message</span>') !!}
        </div>
    </div>
    <div class="form-group">
        <label for="password">Rol</label>
        <select name="role" id="role" class="form-control">
            <option value="admin" <?php echo ($user->role_id== 2) ? 'selected' : '' ?>>Administrador</option>
            <option value="general" <?php echo ($user->role_id == 3) ? 'selected' : '' ?>>Usuario General</option>
        </select>        
    </div>
</form>
@foreach(auth()->user()->role->task as $permiso)
    @if($permiso->task == 'maestros/restablecer')
    <form action="{{ route('restablecer') }}" method="GET" class="reestablecer_contraseña">
        @csrf
        <input type="hidden" name="email" value="{{ $user->email }}">
        <button class=" btn btn-danger" id="editar" type="submit"><?php echo ($user->email == auth()->user()->email) ? 'Cambiar Contraseña' : 'Restablecer Contraseña' ?> </button>
    </form>
    @endif
@endforeach
@endsection