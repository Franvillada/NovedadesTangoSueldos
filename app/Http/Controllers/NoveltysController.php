<?php

namespace App\Http\Controllers;

use App\Novelty;
use App\Client;
use Illuminate\Http\Request;

class NoveltysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexNovedades(){
        $active = ['maestros','novedades'];
        $novedades = $this->obtenerNovedadesEnUso()->paginate(20);
        return view('maestros.novedades')   ->with('active',$active)
                                            ->with('novedades',$novedades);
    }
    
    public function showNuevaRelacionForm(){
        $active = ['maestros','novedades'];
        $novedades = Novelty::all();
        $novedades_disponibles = $novedades->reject(function($value){
            $novedades_en_uso = $this->obtenerNovedadesEnUso();
            return $novedades_en_uso->contains($value);
        });
        return view('maestros.nuevaNovedad')   ->with('active',$active)
                                                ->with('novedades_disponibles',$novedades_disponibles);
    }

    public function nuevaRelacion(Request $request){
        if(session()->has('clienteElegido')){
            $client = session('clienteElegido');
        }else{
            $client = auth()->user()->client;
        }
        foreach($request->novedades as $novedad){
            $client->novelty()->attach(Novelty::where('code',$novedad)->get()->first()->id);
        }

        $updatedClient = Client::where('business_name',$client->business_name)->get()->first();
        session(['clienteElegido' => $updatedClient]);
        return redirect()->route('novedades');
    }

    public function eliminarRelacion(Request $request){
        if(session()->has('clienteElegido')){
            $client = session('clienteElegido');
        }else{
            $client = auth()->user()->client;
        }
        $client->novelty()->detach(Novelty::where('code',$request->code)->get()->first()->id);

        $updatedClient = Client::where('business_name',$client->business_name)->get()->first();
        session(['clienteElegido' => $updatedClient]);
        return redirect()->route('novedades');
    }

    public function obtenerNovedadesEnUso(){
        if(session()->has('clienteElegido')){
            $novedades = session('clienteElegido')->novelty;
        }else{
            $novedades = auth()->user()->client->novelty;
        }
        
        return $novedades;
    }
}
