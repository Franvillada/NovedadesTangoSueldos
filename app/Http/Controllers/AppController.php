<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class AppController extends Controller
{
    public function elegirClienteForm(){
        $clients = Client::all();
        return view('elegirCliente')->with('clients',$clients);
    }

    public function showKpi(){
        return view('kpi')->with('active','kpi');
    }

    public function elegirCliente(Request $request){
        $client = Client::find($request->client);
        session(['clienteElegido' => $client]);
        if($client->business_name == 'Estudio MR y Asociados'){
            $request->session()->forget('clienteElegido');
            return redirect()->route('backend');
        }else{
            return view('kpi')  ->with('active','kpi')
            ->with('client',$client);
        }
        
    }

}
