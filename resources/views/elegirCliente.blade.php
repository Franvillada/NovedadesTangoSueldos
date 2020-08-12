@extends('layouts.home')

@section('content')
<div class="elegir_empresa">
    <p><strong>Elegir Empresa:</strong></p>

    <form action="{{ route('elegir_cliente') }}" method="post">
        @csrf
        <div class="form-group">
            <select name="client" id="client" class="form-control">
                @forelse($clients as $client)
                <option value="{{ $client->id }}">{{ $client->business_name }}</option>
                @empty
                <option disabled selected>No se cargo ninguna empresa</option>
                @endforelse
            </select>
            <div class="{{ $errors->any() ? 'alert alert-danger' : '' }}">
                {!! $errors->first() !!}
            </div>
        </div>
        
        <button type="submit" class="btn boton_principal">Entrar</button>
    </form>
</div>
<a href="{{ route('backend_clientes') }}" class="backend-button btn boton_principal">Administrador</a>
@endsection