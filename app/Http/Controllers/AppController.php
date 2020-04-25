<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function showKpi(){
        return view('kpi')->with('active','kpi');
    }
    public function indexLegajos(){
        $active = ['maestros','legajos'];
        $empleados = auth()->user()->client->employee;
        return view('maestros.legajos') ->with('active',$active)
                                        ->with('empleados',$empleados);
    }
    public function indexNovedades(){
        $active = ['maestros','novedades'];
        return view('maestros.novedades')->with('active',$active);
    }
    public function indexUsuarios(){
        $active = ['maestros','usuarios'];
        return view('maestros.usuarios')->with('active',$active);
    }
}
