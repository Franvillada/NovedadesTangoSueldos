@extends('layouts.app')

@section('content')
    <div class="nav">
        <a class="nav-item {{ ($active === 'kpi') ? 'active' : '' }}" href="{{ route('kpi') }}">KPI's</a>
        <a class="nav-item {{ ($active[0] === 'maestros') ? 'active' : '' }}" href="{{ route('legajos')}}" id="maestros">Maestros</a>
        @if($active[0] === 'maestros')
        <a class="nav-item-child {{ ($active[1] === 'legajos') ? 'active-child' : '' }}" href="{{ route('legajos')}}">Legajos</a>
        <a class="nav-item-child {{ ($active[1] === 'novedades') ? 'active-child' : '' }}" href="{{ route('novedades')}}">Novedades</a>
        <a class="nav-item-child {{ ($active[1] === 'usuarios') ? 'active-child' : '' }}" href="{{ route('usuarios')}}">Usuarios</a>
        @endif
        <a class="nav-item {{ ($active === 'novedades') ? 'active' : '' }}" href="{{ route('registro_novedades') }}">Novedades</a>
    </div>
    <div class="info-container">
        @yield('sub-content')
    </div>
@endsection