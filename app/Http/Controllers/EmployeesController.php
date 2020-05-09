<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use App\Imports\EmployeesImport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexLegajos(){
        $active = ['maestros','legajos'];
        if(session()->has('clienteElegido') && auth()->user()->role->role == 'superadmin'){
            $empleados = Employee::where('client_id',session('clienteElegido')->id)->paginate(10);
        }else{
            $empleados = Employee::where('client_id',auth()->user()->client->id)->paginate(10);
        }
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
        if(session()->has('clienteElegido')){
            $empleados = session('clienteElegido')->employee;
            foreach($empleados as $empleado){
                if($empleado->employee_number == $request->legajo){
                    return back()
                    ->withErrors(['legajo' => 'El Legajo ya se encuentra registrado en el sistema'])
                    ->withInput(request(['legajo']));
                }
            }
            $newLegajo->client_id = session('clienteElegido')->id;
        }else{
            $empleados = auth()->user()->client->employee;
            foreach($empleados as $empleado){
                if($empleado->employee_number == $request->legajo){
                    return back()
                    ->withErrors(['legajo' => 'El Legajo ya se encuentra registrado en el sistema'])
                    ->withInput(request(['legajo']));
                }
            }
            $newLegajo->client_id = auth()->user()->client->id;
        }
        $newLegajo->employee_number = $request->legajo;
        $newLegajo->name = $request->name;
        $newLegajo->entry_date = $request->entry_date;
        $newLegajo->vacations = $request->vacations;
        $newLegajo->scoring = $request->scoring;
        
        $newLegajo->save();
        return redirect()->route('legajos');
    }

    public function showEditarLegajoForm(Request $request){
        $active = ['maestros','legajos'];
        
        $empleado = $this->obtenerEmpleado($request->legajo);
        return view('maestros.editarLegajo')->with('empleado', $empleado)
        ->with('active',$active);
    }

    public function editarLegajo(Request $request){
        $empleado = $this->obtenerEmpleado($request->old_legajo);
        if($request->legajo != $request->old_legajo){
            $empleados = $this->obtenerTodosLosEmpleados();
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
        $empleado = $this->obtenerEmpleado($request->legajo);
        $empleado->active = !$empleado->active;
        $empleado->save();
        return redirect()->route('legajos');
    }

    public function importarLegajos(Request $request)
    {
        $newEmployees = Excel::toCollection(new EmployeesImport(), $request->file('file'));
        $empleados = $this->obtenerTodosLosEmpleados();
        if(session()->has('clienteElegido')){
            $client_id = session('clienteElegido')->id;
        }else{
            $client_id = auth()->user()->client->id;
        }
        foreach($newEmployees[0] as $employee){
            $saved = 0;
            foreach($empleados as $empleado){
                if($empleado->employee_number == $employee['legajo']){
                    $empleado->name = $employee['nombre'];
                    $empleado->entry_date = Date::excelToDateTimeObject($employee['fecha_de_entrada']);
                    $empleado->vacations = $employee['vacaciones_correspondientes'];
                    $empleado->scoring = $employee['scoring'];
                    $empleado->save();
                    $saved = 1;
                    break;   
                }
            }
            if($saved == 0){   
                $newEmployee = new Employee();
                $newEmployee->client_id = $client_id;
                $newEmployee->name = $employee['nombre'];
                $newEmployee->employee_number = $employee['legajo']; 
                $newEmployee->entry_date = Date::excelToDateTimeObject($employee['fecha_de_entrada']);
                $newEmployee->vacations = $employee['vacaciones_correspondientes'];
                $newEmployee->scoring = $employee['scoring'];
                $newEmployee->save();
            };
        } 
        return redirect()->route('legajos');
    }

    public function obtenerEmpleado($legajo){
        if(session()->has('clienteElegido')){
            $empleado = Employee::where('employee_number', $legajo)->where('client_id', session('clienteElegido')->id)->get();
        }else{
            $empleado = Employee::where('employee_number', $legajo)->where('client_id', auth()->user()->client->id)->get();
        }
        return $empleado->first();
    }

    public function obtenerTodosLosEmpleados(){
        if(session()->has('clienteElegido')){
            $empleados = Employee::where('client_id', session('clienteElegido')->id)->get();
        }else{
            $empleados = Employee::where('client_id', auth()->user()->client->id)->get();
        }
        return $empleados;
    }
    
}
