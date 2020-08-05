@extends('layouts.nav')

@section('sub-content')
    <div>
        <h3>Nuevo Legajo</h3>
    </div>

    <form action="" method="POST" class="maestros_form">
        @csrf
        <div class="form-group accept_cancel_button">
            <button class="btn btn-success" type="submit">Aceptar</button>
            <a href="{{ url()->previous() }}" class="btn btn-danger">Cancelar</a>
        </div>
        
        <div class="form-group legajo_numero">
            <label for="legajo">Numero de Legajo:</label>
            <input  class="form-control" 
                    type="number" 
                    name="legajo" 
                    id="legajo"
                    value="{{ old('legajo') }}"
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
                    value="{{ old('name') }}"
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
                    value="{{old('entry_date')}}"
                    >
            <div class="{{ $errors->has('entry_date') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('entry_date', '<span>:message</span>') !!}
            </div>
        </div>

        <div class="form-group legajo_vacaciones">
            <label for="vacations">Vacaciones correspondientes:</label>
            <input  class="form-control" 
                    type="number" 
                    name="vacations" 
                    id="vacations"
                    value="{{ old('vacations') }}"
                    placeholder="">
            <div class="{{ $errors->has('vacations') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('vacations', '<span>:message</span>') !!}
            </div>  
        </div>

        <div class="form-group legajo_scoring">
            <label for="scoring">Scoring</label>
            <input  class="form-control" 
                    type="number" 
                    name="scoring" 
                    id="scoring"
                    value="{{ old('scoring') }}"
                    placeholder="">
            <div class="{{ $errors->has('scoring') ? 'alert alert-danger' : '' }}">
                {!! $errors->first('scoring', '<span>:message</span>') !!}
            </div>   
        </div>
        
    </form>
@endsection