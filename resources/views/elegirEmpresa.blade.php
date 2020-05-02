@extends('layouts.home')

@section('content')
<div class="elegir_empresa">
    <p><strong>Elegir Empresa:</strong></p>

    <form action="{{ route('elegir_empresa') }}" method="post">
        @csrf
        <div class="form-group">
            <select name="client" id="client" class="form-control">
                @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->business_name }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-success">Entrar</button>
    </form>
</div>
@endsection