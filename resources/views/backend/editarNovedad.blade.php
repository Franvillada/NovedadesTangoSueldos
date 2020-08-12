@extends('backend.index')

@section('sub-content')
    <div>
        <h3>Editar Novedad</h3>
    </div>

    <form action="" method="POST" class="maestros_form">
    @csrf
    <div class="form-group accept_cancel_button">
        <button class="btn btn-success" type="submit">Aceptar</button>
        <a href="{{ route('backend_novedades') }}" class="btn btn-danger">Cancelar</a>
    </div>
    <input type="hidden" name="old_code" value="{{ $novedad->code}} ">
    <div class="form-group">
        <label for="code">Codigo:</label>
        <input  class="form-control" 
                type="text" 
                name="code" 
                id="code"
                value="{{ $novedad->code }}">
        <div class="{{ $errors->has('code') ? 'alert alert-danger' : '' }}">
            {!! $errors->first('code', '<span>:message</span>') !!}
        </div>
    </div>

    <div class="form-group">
        <label for="description">Descripción:</label>
        <input  class="form-control" 
                type="text" 
                name="description" 
                id="description"
                value="{{ $novedad->description }}">
        <div class="{{ $errors->has('description') ? 'alert alert-danger' : '' }}">
            {!! $errors->first('description', '<span>:message</span>') !!}
        </div>
    </div>
    
    <div class="form-group">
        <label for="unit">Unidad:</label>
        <input  class="form-control" 
                type="unit" 
                name="unit" 
                id="unit"
                value="{{ $novedad->unit }}" >
        <div class="{{ $errors->has('unit') ? 'alert alert-danger' : '' }}">
            {!! $errors->first('unit', '<span>:message</span>') !!}
        </div>
    </div>

    <div class="form-group">
        <p>Categoria:</p>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="ausentismo" value="absence" <?php echo ($novedad->absence == 1) ? 'checked' : ''?>>
            <label class="form-check-label" for="ausentismo">
                Ausentismo
            </label>
        </div>
        <div class="form-check">   
            <input class="form-check-input" type="checkbox" name="accidente_laboral" value="work_accident" <?php echo ($novedad->work_accident == 1) ? 'checked' : ''?>>
            <label class="form-check-label" for="accidente_laboral">
                Accidente Laboral
            </label> 
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="vacacion" value="vacations" <?php echo ($novedad->vacation == 1) ? 'checked' : ''?>>
            <label class="form-check-label" for="vacaciones">
                Vacaciones
            </label>
        </div>
    </div>
</form>

@endsection