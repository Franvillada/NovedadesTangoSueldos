@extends('layouts.nav')

@section('sub-content')
    <div>
        <h3>Nuevo Registro</h3>
    </div>

    <form action="" method="POST" class="maestros_form">
        @csrf
        <div class="form-group accept_cancel_button">
            <button class="btn btn-success" type="submit">Aceptar</button>
            <button class="btn btn-danger" type="submit">Cancelar</button>
        </div>
        
        <div class="form-group">
            <label for="employee">Empleado:</label>
            <select name="employee" id="employee" class="form-control">
                @foreach($empleados as $empleado){
                    <option value="{{$empleado->id}}">{{ $empleado->employee_number }}: {{$empleado->name}}</option>
                }
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="date">Fecha:</label>
            <input  class="form-control" 
                    type="date" 
                    name="date" 
                    id="date" 
                    >
            <div class="{{ $errors->has('date') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('date', '<span>:message</span>') !!}
            </div>
        </div>

        <div class="form-group">
            <label for="novelty">Novedad:</label>
            <select name="novelty" id="novelty" class="form-control">
                @foreach($novedades as $novedad){
                    <option value="{{$novedad->id}}">{{$novedad->description}} ({{ $novedad->code }})</option>
                }
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Cantidad</label>
            <input  class="form-control" 
                    type="number" 
                    name="quantity" 
                    id="quantity"
                    value="{{ old('quantity') }}"
                    placeholder="">    
        </div>
        
    </form>
@endsection