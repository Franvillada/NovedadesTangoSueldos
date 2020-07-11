@extends('layouts.nav')

@section('sub-content')

<div class="tablero_kpi">
    <div class="tarjeta_kpi">
        <h3>Rotacion del Personal</h3>
        <p>{{$rotacion_del_personal}} %</p>
        <p>Anual</p>
    </div>
    <div class="tarjeta_kpi">
        <h3>Ausentismo Laboral</h3>
        <p>{{$ausentismo_laboral}}</p>
        <p>Mes</p>
    </div>
    <div class="tarjeta_kpi">
        <h3>Accidentalidad Laboral</h3>
        <h4>Legajos</h4>
        <p>{{$accidentalidad_laboral_legajos}}</p>
    </div>
    <div class="tarjeta_kpi">
        <h3>Accidentalidad Laboral</h3>
        <h4>Dias</h4>
        <p>{{$accidentalidad_laboral_dias}}</p>
    </div>
</div>
@endsection