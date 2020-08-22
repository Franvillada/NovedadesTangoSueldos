@extends('layouts.nav')

@section('sub-content')
    <div>
        <h3>Exportar Registros</h3>
    </div>

    <form action="" method="POST" class="exportar_form">
        @csrf
        <p>Seleccione el periodo que desea exportar.</p>
        <div class="form-group">
            <select name="mes" id="mes" class="form-control">
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>
        </div>
        
        <div class="form-group">
            <select name="año" id="año" class="form-control">
                @foreach($years as $year)
                <option value="{{$year}}">{{$year}}</option>
                @endforeach
            </select>
        </div>
        
        <button class="btn btn-success" type="submit">Exportar</button>
    </form>
@endsection