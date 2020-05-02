<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class AppController extends Controller
{
    public function elegirEmpresaForm(){
        $clients = Client::all();
        return view('elegirEmpresa')->with('clients',$clients);
    }

    public function showKpi(){
        return view('kpi')->with('active','kpi');
    }

    public function elegirEmpresa(Request $request){
        $client = Client::where($request->client);
        return view('kpi')  ->with('active','kpi')
                            ->with('client',$client);
    }

}
