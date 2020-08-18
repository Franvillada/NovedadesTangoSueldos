<?php

namespace App\Http\Controllers;

use App\NoveltyRegister;
use App\Employee;
use DB;
use Illuminate\Http\Request;
use App\Exports\NoveltyRegistersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class NoveltyRegistersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session()->has('clienteElegido')){
            $client_id = session('clienteElegido')->id;
        }else{
            $client_id = auth()->user()->client->id;
        }
        $registros = DB::table('novelty_registers')
                        ->join('employees','novelty_registers.employee_id','=','employees.id')
                        ->join('novelties','novelty_registers.novelty_id','=','novelties.id')
                        ->where('employees.client_id','=',$client_id)
                        ->select('novelty_registers.id','novelty_registers.quantity','novelty_registers.date','novelty_registers.informed','employees.employee_number','employees.name','novelties.code','novelties.description')
                        ->orderBy('novelty_registers.date','DESC')
                        ->paginate(20);
        return view('registro_novedades/registroNovedades')->with('active','novedades')
                                        ->with('registros',$registros);
    }

    public function showNuevoRegistroForm(){
        $empleados = $this->obtenerTodosLosEmpleados();
        $novedades = $this->obtenerTodasLasNovedades();
        return view('registro_novedades/nuevoRegistro')
                    ->with('active','novedades')
                    ->with('empleados',$empleados)
                    ->with('novedades',$novedades);
    }

    public function nuevoRegistro(Request $request){
        $validatedData = $request->validate([
            'employee' => 'required',
            'date' => 'required',
            'novelty' => 'required',
            'quantity' => 'required'
        ]);
        
        $registro = new NoveltyRegister();
        $registro->employee_id = $validatedData['employee'];
        $registro->novelty_id = $validatedData['novelty'];
        $registro->date = $validatedData['date'];
        $registro->quantity = $validatedData['quantity'];
        $registro->save();
        return redirect()->route('registro_novedades');
    }

    public function showEditarRegistroForm(Request $request){
        $registro = NoveltyRegister::where('id',$request->registro_id)->first();
        $novedades = $registro->employee->client->novelty;
        return view('registro_novedades/editarRegistro')
                    ->with('active','novedades')
                    ->with('registro',$registro)
                    ->with('novedades',$novedades);
    }

    public function editarRegistro(Request $request){
        $validatedData = $request->validate([
            'date' => 'required',
            'novelty' => 'required',
            'quantity' => 'required'
        ]);
        $registro = NoveltyRegister::where('id',$request->registro_id)->first();

        $registro->novelty_id = $request->novelty;
        $registro->date = $request->date;
        $registro->quantity = $request->quantity;
        $registro->save();
        return redirect()->route('registro_novedades');
    }

    public function cambiarEstadoRegistro(Request $request){
        $registro = NoveltyRegister::where('id',$request->registro_id)->first();

        $registro->informed = 0;
        $registro->save();
        return redirect()->route('registro_novedades');
    }

    public function eliminarRegistro(Request $request){
        $registro = NoveltyRegister::where('id',$request->registro_id)->first();

        $registro->delete();
        return redirect()->route('registro_novedades');
    }

    public function obtenerTodosLosEmpleados(){
        if(session()->has('clienteElegido')){
            $empleados = Employee::where('client_id', session('clienteElegido')->id)->get();
        }else{
            $empleados = Employee::where('client_id', auth()->user()->client->id)->get();
        }
        return $empleados;
    }

    public function obtenerTodasLasNovedades(){
        if(session()->has('clienteElegido')){
            $novedades = session('clienteElegido')->novelty;
        }else{
            $novedades = auth()->user()->client->novelty;
        }

        return $novedades;
    }

    public function showExportarForm(){
        return view('registro_novedades/exportarRegistros')
                    ->with('active','novedades');
    }

    public function storeExcel(Request $request){
        if(session()->has('clienteElegido')){
            $client_id = session('clienteElegido')->id;
        }else{
            $client_id = auth()->user()->client->id;
        }
        if(Excel::store(new NoveltyRegistersExport($request->año,$request->mes,$client_id),'registro_novedades.xlsx')){
            return $this->informarRegistros($request->año,$request->mes,$client_id);
        }else{
            return 'No se pudo exportar el archivo';
        }
        
    }

    public function informarRegistros($año,$mes,$client_id){
        $registros = DB::table('novelty_registers')
                        ->join('employees','novelty_registers.employee_id','=','employees.id')
                        ->join('novelties','novelty_registers.novelty_id','=','novelties.id')
                        ->where('employees.client_id','=',$client_id)
                        ->whereYear('novelty_registers.date',$año)
                        ->whereMonth('novelty_registers.date',$mes)
                        ->select('novelty_registers.id','novelty_registers.quantity','novelty_registers.date','novelty_registers.informed','employees.employee_number','employees.name','novelties.code','novelties.description')
                        ->get();
        foreach ($registros as $registro) {
            $registro_editado = NoveltyRegister::where('id',$registro->id)->first(); 
            $registro_editado->informed = 1;
            $registro_editado->save();
        }
        if(session()->has('clienteElegido')){
            $client_id = session('clienteElegido')->id;
        }else{
            $client_id = auth()->user()->client->id;
        }
        $registros = DB::table('novelty_registers')
                        ->join('employees','novelty_registers.employee_id','=','employees.id')
                        ->join('novelties','novelty_registers.novelty_id','=','novelties.id')
                        ->where('employees.client_id','=',$client_id)
                        ->select('novelty_registers.id','novelty_registers.quantity','novelty_registers.date','novelty_registers.informed','employees.employee_number','employees.name','novelties.code','novelties.description')
                        ->get();
        return view('registro_novedades/registroNovedades')->with('active','novedades')
                                        ->with('registros',$registros)
                                        ->with('informado',1);
    }
    
    public function downloadExcel(){
        return Storage::download('registro_novedades.xlsx');
    }
}
