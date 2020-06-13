@extends('layouts.home')

@section('content')
<div class="elegir_empresa">
    <p><strong>Elegir Empresa:</strong></p>

    <form action="{{ route('elegir_cliente') }}" method="post">
        @csrf
        <div class="form-group">
            <select name="client" id="client" class="form-control">
                @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->business_name }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn boton_principal">Entrar</button>
    </form>
</div>
<a href="{{ route('backend') }}" class="backend-button btn boton_principal">Administrador</a>
@endsection