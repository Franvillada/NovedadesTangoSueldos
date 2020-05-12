@extends('layouts.app')

@section('content')

<div class="nav">
    <a href="{{ route('backend_clientes') }}" class="nav-item">Administrar Clientes</a>
    <a href="{{ route('backend_novedades') }}" class="nav-item">Administrar Novedades</a>
    <a href="{{ route('backend_usuarios') }}" class="nav-item">Administrar Usuarios</a>
</div>
<div class="info-container">
    @yield('sub-content')
</div>
@endsection