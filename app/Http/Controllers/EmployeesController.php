<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use App\Imports\EmployeesImport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Helpers\FileTypeDetector;
use Carbon\Carbon;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexLegajos(){
        $active = ['maestros','legajos'];
        if(session()->has('clienteElegido')){
            $empleados = Employee::where('client_id',session('clienteElegido')->id)
                                ->orderBy('employee_number','ASC')
                                ->paginate(20);
        }else{
            $empleados = Employee::where('client_id',auth()->user()->client->id)
                                ->orderBy('employee_number','ASC')
                                ->paginate(20);;
        }
        $vacacionesGozadasArr = [];
        foreach ($empleados as $empleado) {
            $vacacionesGozadas = $this->obtenerVacacionesGozadas($empleado);
            $vacacionesGozadasArr = Arr::add($vacacionesGozadasArr,$empleado->employee_number,$vacacionesGozadas);
        }
        return view('maestros.legajos') ->with('active',$active)
                                        ->with('empleados',$empleados)
                                        ->with('vacacionesGozadas',$vacacionesGozadasArr);
    }

    public function showNuevoLegajoForm(){
        $active = ['maestros','legajos'];
        return view('maestros.nuevoLegajo')->with('active',$active);
    }

    public function nuevoLegajo(Request $request){
        $data = $this->validate($request,[
            'legajo' => 'required|integer',
            'name' => 'required|string',
            'entry_date' => 'required|date',
            'vacations' => 'required|integer',
            'scoring' => 'nullable|integer'
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
        $vacacionesGozadas = $this->obtenerVacacionesGozadas($empleado);
        return view('maestros.editarLegajo')->with('empleado', $empleado)
                                            ->with('active',$active)
                                            ->with('vacacionesGozadas',$vacacionesGozadas);
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
        $empleado->leave_date = $request->leave_date;
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
        if(FileTypeDetector::detect($request->file('file')) != 'Xlsx'){
            return back()->withErrors('El archivo seleccionado no es compatible');
        }
        try{
            $newEmployees = Excel::toCollection(new EmployeesImport(), $request->file('file'));
        }catch(\Exception $ex){
            $request->session()->flash('status','Fallo la Importacion');
            return back()->withErrors('Algo salio mal. Si el Error sigue ocurriendo contacta al proveedor del servicio');
        }
        
        foreach($newEmployees[0] as $employee){
            if( (count($employee) != 5) || !(isset($employee['nombre'])) || !(isset($employee['legajo'])) || !(isset($employee['fecha_de_entrada'])) || !(isset($employee['vacaciones_correspondientes'])) || !(isset($employee['scoring'])) ){
                $request->session()->flash('status','Fallo la Importacion');
                return back()->withErrors('El formato de la tabla excel no es correcto');
            }
            elseif($employee['nombre'] == NULL){
                $request->session()->flash('status','Fallo la Importacion');
                return back()->withErrors('Falta completar nombre de uno o mas legajos');
            }elseif($employee['legajo'] == NULL){
                $request->session()->flash('status','Fallo la Importacion');
                return back()->withErrors('Falta completar numero de uno o mas legajos');
            }elseif($employee['fecha_de_entrada'] == NULL){
                $request->session()->flash('status','Fallo la Importacion');
                return back()->withErrors('Falta completar fecha de ingreso de uno o mas legajos');
            }
        }
        
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
                    try {
                        $empleado->entry_date = Date::excelToDateTimeObject($employee['fecha_de_entrada']);
                    } catch (\Exception $ex) {
                        $empleado->entry_date = date('Y-m-d',strtotime(str_replace('/','-',$employee['fecha_de_entrada'])));
                    }
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
                try {
                    $newEmployee->entry_date = Date::excelToDateTimeObject($employee['fecha_de_entrada']);
                } catch (\Exception $ex) {
                    $newEmployee->entry_date = date('Y-m-d',strtotime(str_replace('/','-',$employee['fecha_de_entrada'])));
                }
                $newEmployee->employee_number = $employee['legajo'];
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

    public function obtenerVacacionesGozadas($empleado){
        $vacacionesGozadas = 0;
        $registros = $empleado->noveltyRegister;
        foreach ($registros as $registro) {
            if($registro->novelty->vacation == 1){
                $vacacionesGozadas += $registro->quantity;
            }
        }
        return $vacacionesGozadas;
    }
}
