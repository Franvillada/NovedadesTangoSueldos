@extends('layouts.nav')

@section('sub-content')
<div>
    <h3>Maestros - Usuarios</h3>
    <h6>Editar Usuario</h6>
</div>
<form action="{{ route('reestablecer') }}" method="POST" class="reestablecer_form">
    @csrf
    <input type="hidden" name="email" value="{{ $user->email }}">
    <div class="form-group w-25">
        <label for="password">Nueva Contraseña:</label>
        <input  class="form-control" 
                type="password" 
                name="password" 
                id="password" 
                >
        <div class="{{ $errors->has('password') ? 'alert alert-danger' : '' }}">
            {!! $errors->first('password', '<span>:message</span>') !!}
        </div>
    </div>
    <button type="submit" class="btn btn-success">Establecer</button>
</form>
@endsection