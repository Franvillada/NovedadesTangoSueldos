@extends('layouts.nav')

@section('sub-content')

<div class="tablero_kpi">

    <div class="card mb-3 mr-3">
        <div class="card-header">
            <h5>Rotacion del Personal</h5>
        </div>
        <div class="card-body">
            <p class="kpi">{{$rotacion_del_personal}} %</p>
            <p class="periodo">(Anual)</p>
        </div>
    </div>

    <div class="card mb-3 ml-3">
        <div class="card-header">
            <h5>Ausentismo Laboral</h5>
        </div>
        <div class="card-body">
            <p class="kpi">{{$ausentismo_laboral}} %</p>
            <p class="periodo">(Mensual)</p>
        </div>
    </div>

    <div class="card mt-3 mr-3">
        <div class="card-header">
            <h5>Accidentalidad Laboral (Legajos)</h5>
        </div>
        <div class="card-body">
            <p class="kpi">{{$accidentalidad_laboral_legajos}}</p>
            <p class="periodo">(Mensual)</p>
        </div>
    </div>

    <div class="card mt-3 ml-3">
        <div class="card-header">
        <h5>Accidentalidad Laboral (Dias)</h5>
        </div>
        <div class="card-body">
            <p class="kpi">{{$accidentalidad_laboral_dias}}</p>
            <p class="periodo">(Mensual)</p>
        </div>
    </div>
   
</div>
@endsection