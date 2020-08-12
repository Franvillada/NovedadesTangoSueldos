@extends('backend.index')

@section('sub-content')
    <div>
        <h3>Nuevo Superadmin</h3>
    </div>

    <form action="" method="POST" class="maestros_form">
        @csrf
        <div class="form-group accept_cancel_button">
            <button class="btn btn-success" type="submit">Aceptar</button>
            <a href="{{ route('backend_usuarios') }}" class="btn btn-danger">Cancelar</a>
        </div>
        <div class="form-group">
            <label for="username">Nombre de Usuario:</label>
            <input  class="form-control" 
                    type="text" 
                    name="username" 
                    id="username"
                    value="{{ old('username') }}">
            <div class="{{ $errors->has('username') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('username', '<span>:message</span>') !!}
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input  class="form-control" 
                    type="email" 
                    name="email" 
                    id="email"
                    value="{{ old('email') }}">
            <div class="{{ $errors->has('email') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('email', '<span>:message</span>') !!}
            </div>
        </div>
        
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input  class="form-control" 
                    type="password" 
                    name="password" 
                    id="password" >
            <div class="{{ $errors->has('password') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('password', '<span>:message</span>') !!}
            </div>
        </div>

        <div class="form-group">
            <label for="role">Rol:</label>
            <select name="role" id="role" class="form-control">
                <option value="superadmin" selected>Superadmin</option>
            </select>
        </div>
        
    </form>


@endsection