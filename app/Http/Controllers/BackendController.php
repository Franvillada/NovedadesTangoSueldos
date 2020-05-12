<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class BackendController extends Controller
{
    public function index(){
        return view('backend.index');
    }

    public function indexClientes(){
        $clientes = Client::paginate(10);
        return view('backend.clientes')->with('clientes',$clientes);
    }

    public function showNuevoClienteForm(){
        return view('backend.nuevoCliente');
    }

    public function añadirCliente(Request $request){
        $data = $this->validate($request,[
            'business_name' => 'string|required',
        ]);
        $cliente = new Client();
        
        $cliente->business_name = $request->business_name;
        $cliente->save();
        
        return redirect()->route('backend_clientes');
    }

    public function showEditarClienteForm(Request $request){
        $cliente = Client::where('business_name',$request->business_name)->get()->first();
    
        return view('backend.editarCliente')->with('cliente',$cliente);
    }

    public function editarCliente(Request $request){
        $data = $this->validate($request,[
            'business_name' => 'string|required',
        ]);
        
        $cliente = Client::where('business_name',$request->old_business_name)->get()->first();
        
        $cliente->business_name = $request->business_name;
        $cliente->save();
        return redirect()->route('backend_clientes');
    }

    public function cambiarEstadoCliente(Request $request){
        $cliente = Client::where('business_name',$request->business_name)->get()->first();
        
        $cliente->active = !$cliente->active;
        $cliente->save();
        return redirect()->route('backend_clientes');
    }
}
