<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\NoveltyRegister;
use App\Employee;

class AppController extends Controller
{
    public function elegirClienteForm(){
        $clients = Client::all();
        return view('elegirCliente')->with('clients',$clients);
    }

    public function showKpi(){
        if(session()->has('clienteElegido')){
            $client_id = session('clienteElegido')->id;
        }else{
            $client_id = auth()->user()->client->id;
        }
        $empleados = Employee::where('client_id',$client_id)->get();
        $bajas = $empleados->reject(function($empleado){
            return $empleado->leave_date == NULL; 
        })->count();
        $cantidad_legajos_actual = $empleados->reject(function($empleado){
            return $empleado->leave_date !=NULL;
        })->count();
        $legajos_al_inicio = $empleados->reject(function($empleado){
            return $empleado->leave_date <= date('Y-m-d', strtotime('first day of january this year')) && $empleado->leave_date !=NULL;
        })->count();
        if($legajos_al_inicio + $cantidad_legajos_actual === 0){
            $rotacion_del_personal = 0;
        }else{
            $rotacion_del_personal = number_format((float)$bajas/(($legajos_al_inicio + $cantidad_legajos_actual)/2)*100,2,'.','');
        }
        
        $registros = NoveltyRegister::join('employees','novelty_registers.employee_id','=','employees.id')
                                        ->join('novelties','novelty_registers.novelty_id','=','novelties.id')
                                        ->where('employees.client_id','=',$client_id)->get();
        $ausencias_del_mes =  $registros->filter(function($registro){
            return $registro->absence === 1;
        });
        $ausencia_total_dias = 0;
        foreach ($ausencias_del_mes as $ausencia) {
            $ausencia_total_dias += $ausencia->quantity; 
        }
        if($cantidad_legajos_actual === 0){
           $ausentismo_laboral = 0; 
        }else{
            $ausentismo_laboral = number_format((float)$ausencia_total_dias/(date('t')*$cantidad_legajos_actual)*100,2,'.','');
        }
        

        $accidentes_del_mes = $registros->filter(function($registro){
            return $registro->work_accident === 1;
        });
        $accidentalidad_laboral_dias = 0;
        $accidentalidad_laboral_legajos = 0;
        $legajos_con_accidentes = collect([]);
        foreach ($accidentes_del_mes as $accidente) {
            if(!$legajos_con_accidentes->contains($accidente->employee_number)){
                $legajos_con_accidentes->push($accidente->employee_number);
            }
            $accidentalidad_laboral_dias += $accidente->quantity;
        }
        $accidentalidad_laboral_legajos = $legajos_con_accidentes->count();
        
        
        return view('kpi')->with('active','kpi')
                            ->with('rotacion_del_personal',$rotacion_del_personal)
                            ->with('ausentismo_laboral',$ausentismo_laboral)
                            ->with('accidentalidad_laboral_legajos',$accidentalidad_laboral_legajos)
                            ->with('accidentalidad_laboral_dias',$accidentalidad_laboral_dias);
    }

    public function elegirCliente(Request $request){
        $client = Client::find($request->client);
        session(['clienteElegido' => $client]);
        if($client->business_name == 'Estudio MR y Asociados'){
            $request->session()->forget('clienteElegido');
            return redirect()->route('backend');
        }else{
            return redirect()->route('kpi')  ->with('active','kpi')
            ->with('client',$client);
        }
        
    }

}
