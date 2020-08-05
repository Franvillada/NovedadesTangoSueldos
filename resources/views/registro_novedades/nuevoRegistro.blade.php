@extends('layouts.nav')

@section('sub-content')
    <div>
        <h3>Nuevo Registro</h3>
    </div>

    <form action="" method="POST" class="maestros_form">
        @csrf
        <div class="form-group accept_cancel_button">
            <button class="btn btn-success" type="submit">Aceptar</button>
            <a href="{{ url()->previous() }}" class="btn btn-danger">Cancelar</a>
        </div>
        
        <div class="form-group">
            <label for="employee">Empleado:</label>
            <select name="employee" id="employee" class="form-control">
                @forelse($empleados as $empleado)
                    <option value="{{$empleado->id}}">{{ $empleado->employee_number }}: {{$empleado->name}}</option>
                @empty
                    <option value="">No hay legajos cargadas</option>
                @endforelse
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
                @forelse($novedades as $novedad)
                    <option value="{{$novedad->id}}">{{$novedad->description}} ({{ $novedad->code }})</option>
                @empty
                    <option value="">No hay Novedades cargadas</option>
                @endforelse
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