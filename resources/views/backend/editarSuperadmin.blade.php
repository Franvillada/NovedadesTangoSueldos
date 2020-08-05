@extends('backend.index')

@section('sub-content')
    <div>
        <h3>Editar Superadmin</h3>
    </div>

    <form action="" method="POST" class="maestros_form_usuarios">
        @csrf
        <div class="form-group accept_cancel_button">
            <button class="btn btn-success" type="submit">Aceptar</button>
            <a href="{{ url()->previous() }}" class="btn btn-danger">Cancelar</a>
        </div>
        <div class="form-group">
            <label for="username">Nombre de Usuario:</label>
            <input  class="form-control" 
                    type="text" 
                    name="username" 
                    id="username"
                    value="{{ $user->username }}">
            <div class="{{ $errors->has('username') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('username', '<span>:message</span>') !!}
            </div>
        </div>
        
        <input type="hidden" name="old_email" value="{{ $user->email }} ">
        <div class="form-group">
            <label for="email">Email:</label>
            <input  class="form-control" 
                    type="email" 
                    name="email" 
                    id="email"
                    value="{{ $user->email }}">
            <div class="{{ $errors->has('email') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('email', '<span>:message</span>') !!}
            </div>
        </div>
        
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input  class="form-control" 
                    type="password" 
                    name="password" 
                    id="password" 
                    value="***********" disabled>
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

    @if(auth()->user()->role->role == 'superadmin')
        <form action="{{ route('reestablecer_superadmin') }}" method="GET" class="reestablecer_contraseña">
            @csrf
            <input type="hidden" name="email" value="{{ $user->email }}">
            <button class=" btn btn-danger" id="editar" type="submit"><?php echo ($user->email == auth()->user()->email) ? 'Cambiar Contraseña' : 'Reestablecer Contraseña' ?> </button>
        </form>
    @endif
                
    


@endsection