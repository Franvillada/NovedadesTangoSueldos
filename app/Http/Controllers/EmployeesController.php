<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexLegajos(){
        $active = ['maestros','legajos'];
        $empleados = Employee::where('client_id',auth()->user()->client->id)->paginate(10);
        return view('maestros.legajos') ->with('active',$active)
                                        ->with('empleados',$empleados);
    }

    public function showNuevoLegajoForm(){
        $active = ['maestros','legajos'];
        return view('maestros.nuevoLegajo')->with('active',$active);
    }

    public function añadirLegajo(Request $request){
        $data = $this->validate($request,[
            'legajo' => 'integer|required',
            'name' => 'required|string',
            'entry_date' => 'required|date',
            'vacations' => 'integer|required',
            'scoring' => 'integer'
        ]);
    
        $newLegajo = new Employee();
        $newLegajo->employee_number = $request->legajo;
        $newLegajo->name = $request->name;
        $newLegajo->entry_date = $request->entry_date;
        $newLegajo->vacations = $request->vacations;
        $newLegajo->scoring = $request->scoring;
        $newLegajo->client_id = auth()->user()->client->id;
        
        $empleados = auth()->user()->client->employee;
        foreach($empleados as $empleado){
            if($empleado->employee_number == $request->legajo){
                return back()
                ->withErrors(['legajo' => 'El Legajo ya se encuentra registrado en el sistema'])
                ->withInput(request(['legajo']));
            }
        }
        $newLegajo->save();
        return redirect()->route('legajos');
    }

    public function showEditarLegajoForm(Request $request){
        $active = ['maestros','legajos'];
        $empleado = Employee::where('employee_number', $request->legajo)->where('client_id', auth()->user()->client->id)->get();
        return view('maestros.editarLegajo')->with('empleado', $empleado->first())
        ->with('active',$active);
    }

    public function editarLegajo(Request $request){
        $empleado = Employee::where('employee_number', $request->old_legajo)->where('client_id', auth()->user()->client->id)->get()->first();
        if($request->legajo != $request->old_legajo){
            $empleados = auth()->user()->client->employee;
            foreach($empleados as $employee){
            if($employee->employee_number == $request->legajo){
                return back()
                ->withErrors(['legajo' => 'El Legajo ya se encuentra registrado en el sistema'])
                ->withInput(request(['legajo']));
            }
        }
        }
        $empleado->employee_number = $request->legajo;
        $empleado->name = $request->name;
        $empleado->entry_date = $request->entry_date;
        $empleado->vacations = $request->vacations;
        $empleado->scoring = $request->scoring;
       
        $empleado->save();
        return redirect()->route('legajos'); 
    }

    public function cambiarEstadoLegajo(Request $request){
        $empleado = Employee::where('employee_number', $request->legajo)->where('client_id', auth()->user()->client->id)->get()->first();
        $empleado->active = !$empleado->active;
        $empleado->save();
        return redirect()->route('legajos');
    }
}
