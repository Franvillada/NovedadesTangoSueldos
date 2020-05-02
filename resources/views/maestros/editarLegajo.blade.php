@extends('layouts.nav')

@section('sub-content')
    <div>
        <h3>Maestros - Legajos</h3>
        <h6>Editar Legajo</h6>
    </div>

    <form action="{{ route('editar_legajo') }}" method="POST" class="maestros_form">
        @csrf
        <div class="form-group accept_cancel_button">
            <button class="btn btn-success" type="submit">Aceptar</button>
            <button class="btn btn-danger" type="submit">Cancelar</button>
        </div>
        <input type="hidden" name="old_legajo" value="{{ $empleado->employee_number}} ">
        <div class="form-group legajo_numero">
            <label for="legajo">Numero de Legajo:</label>
            <input  class="form-control" 
                    type="number" 
                    name="legajo" 
                    id="legajo"
                    value="{{ $errors->has('legajo') ? old('legajo') : $empleado->employee_number }}"
                    placeholder="">
            <div class="{{ $errors->has('legajo') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('legajo', '<span>:message</span>') !!}
            </div>
        </div>

        <div class="form-group legajo_nombre">
            <label for="name">Nombre y Apellido</label>
            <input  class="form-control" 
                    type="text" 
                    name="name" 
                    id="name"
                    value="{{ $empleado->name }}"
                    placeholder="">
            <div class="{{ $errors->has('name') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('username', '<span>:message</span>') !!}
            </div>
        </div>
        
        <div class="form-group legajo_fecha">
            <label for="entry_date">Dia de Ingreso:</label>
            <input  class="form-control" 
                    type="date" 
                    name="entry_date" 
                    id="entry_date"
                    value="{{$empleado->entry_date}}" 
                    >
            <div class="{{ $errors->has('entry_date') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('entry_date', '<span>:message</span>') !!}
            </div>
        </div>

        <div class="form-group legajo_fecha">
            <label for="leave_date">Dia de Egreso:</label>
            <input  class="form-control" 
                    type="date" 
                    name="leave_date" 
                    id="leave_date"
                    value="{{$empleado->leave_date}}" 
                    >
            <div class="{{ $errors->has('leave_date') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('leave_date', '<span>:message</span>') !!}
            </div>
        </div>

        <div class="form-group legajo_vacaciones">
            <label for="vacations">Vacaciones correspondientes:</label>
            <input  class="form-control" 
                    type="number" 
                    name="vacations" 
                    id="vacations"
                    value="{{ $empleado->vacations }}"
                    placeholder="">    
        </div>

        <div class="form-group legajo_scoring">
            <label for="scoring">Scoring</label>
            <input  class="form-control" 
                    type="number" 
                    name="scoring" 
                    id="scoring"
                    value="{{ $empleado->scoring }}"
                    placeholder="">    
        </div>
        
    </form>
@endsection