@extends('layouts.nav')

@section('sub-content')
    <div>
        <h3>Editar Registro</h3>
    </div>

    <form action="" method="POST" class="maestros_form">
        @csrf
        <div class="form-group accept_cancel_button">
            <button class="btn btn-success" type="submit">Aceptar</button>
            <a href="{{ url()->previous() }}" class="btn btn-danger">Cancelar</a>
        </div>
        <input type="hidden" name="registro_id" value="{{ $registro->id}} ">
        <div class="form-group">
            <label for="employee">Empleado:</label>
            <select name="employee" id="employee" class="form-control" disabled>
               <option value="{{$registro->employee->id}}">{{ $registro->employee->employee_number }}: {{$registro->employee->name}}</option>
            </select>
        </div>

        <div class="form-group">
            <label for="date">Fecha:</label>
            <input  class="form-control" 
                    type="date" 
                    name="date" 
                    id="date"
                    value="{{ $registro->date }}" 
                    >
            <div class="{{ $errors->has('date') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('date', '<span>:message</span>') !!}
            </div>
        </div>

        <div class="form-group">
            <label for="novelty">Novedad:</label>
            <select name="novelty" id="novelty" class="form-control">
                @foreach($novedades as $novedad){
                    <option value="{{$novedad->id}}" <?php echo ($novedad->id== $registro->novelty_id) ? 'selected' : '' ?>>{{ $novedad->code }}: {{$novedad->description}}</option>
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
                    value="{{$registro->quantity }}"
                    placeholder="">    
        </div>
        
    </form>
@endsection