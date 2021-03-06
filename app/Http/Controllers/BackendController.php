<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Novelty;
use App\User;
use App\Imports\NoveltiesImport;
use App\Imports\ClientsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Helpers\FileTypeDetector;

class BackendController extends Controller
{

    public function indexClientes(){
        $clientes = Client::where('business_name','!=','Estudio MR y Asociados')
                            ->orderBy('business_name','ASC')
                            ->paginate(20);
        return view('backend.clientes')->with('clientes',$clientes);
    }

    public function showNuevoClienteForm(){
        return view('backend.nuevoCliente');
    }

    public function nuevoCliente(Request $request){
        $data = $this->validate($request,[
            'business_name' => 'bail|required|string|unique:clients',
        ]);
        $cliente = new Client();
        
        $cliente->business_name = $request->business_name;
        $cliente->save();

        $clients = Client::all()->reject(function ($value){
            return ($value->business_name == 'Estudio MR y Asociados') || ($value->active == 0) ;
        });
        $request->session()->put('clientes', $clients);
        
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
        $this->cambiarEstadoUsuarios($cliente,$cliente->user);
        $cliente->active = !$cliente->active;
        $cliente->save();
        $clients = Client::all()->reject(function ($value){
            return ($value->business_name == 'Estudio MR y Asociados') || ($value->active == 0) ;
        });
        $request->session()->put('clientes', $clients);
        return redirect()->route('backend_clientes');
    }

    public function cambiarEstadoUsuarios($cliente,$usuarios){
        if($cliente->active == 1){
            foreach($usuarios as $usuario){
                $usuario->active = 0;
                $usuario->save();
            }
        }elseif($cliente->active == 0){
            foreach($usuarios as $usuario){
                $usuario->active = 1;
                $usuario->save();
            }
        }
        
    }

    public function indexNovedades(){
        $novedades = Novelty::orderBy('code','ASC')->paginate(20);
        return view('backend.novedades')->with('novedades',$novedades);
    }

    public function showNuevaNovedadForm(){
        return view('backend.nuevaNovedad');
    }

    public function nuevaNovedad(Request $request){
        $data = $this->validate($request,[
            'code' => 'required|string',
            'description' => 'required|string',
            'unit' => 'required|string',
        ]);

        foreach(Novelty::all() as $novedad){
            if($novedad->code == $request->code){
                return back()
                    ->withErrors(['code' => 'El codigo ya se encuentra registrado en el sistema'])
                    ->withInput(request(['code']));
            }
        }
        $novedad = new Novelty();
        $novedad->code = $request->code;
        $novedad->unit = $request->unit;
        $novedad->description = $request->description;
        if($request->ausentismo){
            $novedad->absence = 1;
        }
        if($request->accidente_laboral){
            $novedad->work_accident = 1;
        }
        if($request->vacacion){
            $novedad->vacation = 1;
        }
        $novedad->save();
        return redirect()->route('backend_novedades');
    }

    public function showEditarNovedadForm(Request $request){
        return view('backend.editarNovedad')->with('novedad',Novelty::where('code',$request->code)->get()->first());
    }

    public function editarNovedad(Request $request){
        $data = $this->validate($request,[
            'code' => 'required|string',
            'description' => 'required|string',
            'unit' => 'required|string',
        ]);

        if($request->code != $request->old_code){
            foreach(Novelty::all() as $novedad){
                if($novedad->code == $request->code){
                    return back()
                    ->withErrors(['code' => 'El codigo ya se encuentra registrado en el sistema'])
                    ->withInput(request(['code']));
                }
            }
        }
        
        $novedad = Novelty::where('code',$request->old_code)->get()->first();
        $novedad->code = $request->code;
        $novedad->description = $request->description;
        $novedad->unit = $request->unit;
        if($request->ausentismo){
            $novedad->absence = 1;
        }else{
            $novedad->absence = 0;
        }
        if($request->accidente_laboral){
            $novedad->work_accident = 1;
        }else{
            $novedad->work_accident = 0;
        }
        if($request->vacacion){
            $novedad->vacation = 1;
        }else{
            $novedad->vacation = 0;
        }
        $novedad->save();
        return redirect()->route('backend_novedades');
    }

    public function cambiarEstadoNovedad(Request $request){
        $novedad = Novelty::where('code',$request->code)->get()->first();
        if($novedad->active == 1){
            $this->eliminarRelaciones($novedad);
        }
        $novedad->active = !$novedad->active;
        $novedad->save();
        
        return redirect()->route('backend_novedades');
    }
    
    public function eliminarRelaciones($novedad){
        $clientes = Client::all()->reject(function ($value){
            return $value->business_name == 'Estudio MR y Asociados';
        });
        foreach($clientes as $cliente){
            $cliente->novelty()->detach(Novelty::where('code',$novedad->code)->get()->first()->id);    
        }
    }

    public function importarNovedad(Request $request){
        if(FileTypeDetector::detect($request->file('file')) != 'Xlsx'){
            return back()->withErrors('El archivo seleccionado no es compatible');
        }
        try{
            $newNovelties = Excel::toCollection(new NoveltiesImport(), $request->file('file'));
        }catch(\Exception $ex){
            $request->session()->flash('status','Fallo la Importacion');
            return back()->withErrors('Algo salio mal. Si el Error sigue ocurriendo contacta al proveedor del servicio');
        }
        
        foreach($newNovelties[0] as $novelty){
            if( (count($novelty) != 3) || !(isset($novelty['codigo'])) || !(isset($novelty['descripcion'])) || !(isset($novelty['unidad'])) ){
                $request->session()->flash('status','Fallo la Importacion');
                return back()->withErrors('El formato de la tabla excel no es correcto');
            }elseif($novelty['codigo'] == NULL){
                $request->session()->flash('status','Fallo la Importacion');
                return back()->withErrors('Falta completar codigo de una o mas novedades');
            }elseif($novelty['descripcion'] == NULL){
                $request->session()->flash('status','Fallo la Importacion');
                return back()->withErrors('Falta completar descripcion de una o mas novedades');
            }elseif($novelty['unidad'] == NULL){
                $request->session()->flash('status','Fallo la Importacion');
                return back()->withErrors('Falta completar unidad de una o mas novedades');
            }
        }
        
        $novedades = Novelty::all();
        
        foreach($newNovelties[0] as $novelty){
            $saved = 0;
            foreach($novedades as $novedad){
                if($novedad->code == $novelty['codigo']){
                    $novedad->description = $novelty['descripcion'];
                    $novedad->unit = $novelty['unidad'];
                    $novedad->save();
                    $saved = 1;
                    break;   
                }
            }
            if($saved == 0){   
                $newNovelty = new Novelty();
                $newNovelty->code = $novelty['codigo'];
                $newNovelty->description = $novelty['descripcion'];
                $newNovelty->unit = $novelty['unidad']; 
                $newNovelty->save();
            };
        }
        return redirect()->route('backend_novedades');
    }

    public function indexUsuarios(){
        $usuarios = User::where('client_id',auth()->user()->client->id)
                        ->orderBy('username','ASC')
                        ->paginate(20);
        return view('backend.usuarios')->with('usuarios',$usuarios);
    }

    public function showNuevoSuperadminForm(){
        return view('backend.nuevoSuperadmin');
    }

    public function superadmin(Request $request){
        $credentials = $this->validate($request,[
            'email' => 'bail|email|required|string|unique:users',
            'username' => 'bail|required|string',
            'password' => 'required|string',
            'role' => 'required'
        ]);
        $newSuperadmin = new User();
        $newSuperadmin->email = $credentials['email'];
        $newSuperadmin->username = $credentials['username'];
        $newSuperadmin->password = Hash::make('password');
        $newSuperadmin->client_id = auth()->user()->client->id;
        $newSuperadmin->role_id = auth()->user()->role->id;

        $newSuperadmin->save();
        return redirect()->route('backend_usuarios');
    }

    public function showEditarSuperadminForm(Request $request){
        return view('backend.editarSuperadmin')->with('user',User::where('email',$request->email)->get()->first());
    }

    public function editarSuperadmin(Request $request){
        $credentials = $this->validate($request,[
            'email' => 'bail|email|required|string',
            'username' => 'bail|required|string',
            'role' => 'required'
        ]);
        $superadmin = User::where('email', $request->old_email)->get()->first();
        
        $superadmin->email = $request->email;
        $superadmin->username = $request->username;
        
        $superadmin->save();
        return redirect()->route('backend_usuarios');
    }

    public function showReestablecerForm(Request $request){
        $superadmin = User::where('email', $request->email)->get()->first();
        return view('backend.reestablecer')->with('user',$superadmin);
    }

    public function reestablecerPassword(Request $request){
        $superadmin = User::where('email',$request->email)->get()->first();
        $superadmin->password = Hash::make($request->password);
        $superadmin->save();
        return redirect()->route('backend_usuarios');
    }

    public function importarClientes(Request $request){
        if(FileTypeDetector::detect($request->file('file')) != 'Xlsx'){
            return back()->withErrors('El archivo seleccionado no es compatible');
        }
        try{
            $newClients = Excel::toCollection(new ClientsImport(), $request->file('file'));
        }catch(\Exception $ex){
            $request->session()->flash('status','Fallo la Importacion');
            return back()->withErrors('Algo salio mal. Si el Error sigue ocurriendo contacta al proveedor del servicio');
        }
        
        foreach($newClients[0] as $client){
            if( (count($client) != 1) || !(isset($client['razon_social'])) ){
                $request->session()->flash('status','Fallo la Importacion');
                return back()->withErrors('El formato de la tabla excel no es correcto');
            }elseif($client['razon_social'] == NULL){
                $request->session()->flash('status','Fallo la Importacion');
                return back()->withErrors('Falta completar la razon social de uno o mas clientes');
            }
        }
        $clientes = Client::all()->reject(function ($value){
            return $value->business_name == 'Estudio MR y Asociados';
        });
        foreach($newClients[0] as $client){
            $alreadyExist = 0;
            foreach($clientes as $cliente){
                if($cliente->business_name == $client['razon_social']){
                    $alreadyExist = 1;       
                }
            }
            if($alreadyExist == 0){
                $newClient = new Client();
                $newClient->business_name = $client['razon_social']; 
                $newClient->save();
            }
        }
        $request->session()->put('clientes', Client::all()->reject(function ($value){
            return $value->business_name == 'Estudio MR y Asociados';
        }));
        return redirect()->route('backend_clientes');
    }
}
