<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\NoveltyRegister;
use App\Employee;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AppController extends Controller
{
    public function elegirClienteForm(){
        $clients = Client::all()->reject(function ($value,$key){
            return $value->business_name == 'Estudio MR y Asociados';
        });
        return view('elegirCliente')->with('clients',$clients);
    }

    public function elegirCliente(Request $request){
        if($request->client == null){
            return back()->withErrors('Debe elegir una empresa');
        }
        $client = Client::find($request->client);
        $request->session()->put('clienteElegido', $client);
        if($client->business_name == 'Estudio MR y Asociados'){
            $request->session()->forget('clienteElegido');
            return redirect()->route('backend_clientes');
        }else{
            return redirect()->route('kpi')  ->with('active','kpi')
            ->with('client',$client);
        }
        
    }

    public function showKpi(){
        if(session()->has('clienteElegido')){
            $client_id = session('clienteElegido')->id;
        }else{
            $client_id = auth()->user()->client->id;
        }
        $empleados = Employee::where('client_id',$client_id)->get();
        
        /* Calculo de la Rotacion del Personal */

            /*Obtengo las Bajas del Periodo */
            $bajas = $empleados->filter(function($empleado){
                return date('Y',strtotime($empleado->leave_date)) == now()->year;
            })->count();

            /* Obtengo la cantidad de Legajos al Inicio del Periodo */
            $legajos_al_inicio = $empleados->reject(function($empleado){
                return ( (date('Y',strtotime($empleado->leave_date)) < now()->year && $empleado->leave_date != NULL) || ( date('Y',strtotime($empleado->entry_date)) == now()->year) );
            })->count();
            
            /* Obtengo la cantidad de Legajos Actuales */
            $cantidad_legajos_actual = $empleados->reject(function($empleado){
                return $empleado->leave_date !=NULL;
            })->count();
            
            /* Chequeo que no sea una division por 0 y calculo*/
            if($legajos_al_inicio + $cantidad_legajos_actual === 0){
                $rotacion_del_personal = 0;
            }else{
                $rotacion_del_personal = number_format((float)$bajas/(($legajos_al_inicio + $cantidad_legajos_actual)/2)*100,2,'.','');
            }
        
        
        $registros = NoveltyRegister::join('employees','novelty_registers.employee_id','=','employees.id')
                                        ->join('novelties','novelty_registers.novelty_id','=','novelties.id')
                                        ->where('employees.client_id','=',$client_id)
                                        ->whereYear('novelty_registers.date',now()->year)
                                        ->whereMonth('novelty_registers.date',now()->month)
                                        ->get();
        
        /* Calculo del Ausentismo Laboral */
        
        /* Tomo todos los registros del mes con novedad perteneciente a ausentismo */
        $ausencias_del_mes =  $registros->filter(function($registro){
            return $registro->absence === 1 ;
        });

        /* Sumo todos los dias de los registros para tener el total de dias ausentes */
        $ausencia_total_dias = 0;
        foreach ($ausencias_del_mes as $ausencia) {
            $ausencia_total_dias += $ausencia->quantity; 
        }
        
        /* Calculo la cantidad de dias laborales del mes */
        $dias_del_mes = Carbon::now()->daysInMonth;
        $fin_de_semana = 0;
        $startDate = Carbon::parse(date('Y-m'))->startOfMonth();
        $endDate = Carbon::parse(date('Y-m'))->endOfMonth();
        foreach(CarbonPeriod::create($startDate, $endDate) as $date){
            if($date->isWeekend()){
                $fin_de_semana += 1;
            }
        }
        $dias_laborales = $dias_del_mes - $fin_de_semana;

        /* Tomo la cantidad de legajos actuales calculado para el KPI anterior y verifico que no sea 0 para que no sea una division por 0 */
        if($cantidad_legajos_actual === 0){
           $ausentismo_laboral = 0; 
        }
        /* Si no es 0 calculo el indicador */
        else{
            $ausentismo_laboral = number_format((float)$ausencia_total_dias/($dias_laborales * $cantidad_legajos_actual)*100,2,'.','');
        }
        
        /* Calculo de la accidentalidad laboral (En dias y en Legajos) */

        /* Tomo todos los registros pertenecientes a accidentes laborales */
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

}
