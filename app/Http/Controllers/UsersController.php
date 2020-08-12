<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUsuarios(){
        $active = ['maestros','usuarios'];
        return view('maestros.usuarios')->with('active',$active)
                                        ->with('users',$this->obtenerTodosLosUsuarios());
    }

    public function login(Request $request){
        $credentials = $this->validate($request, [
            'email' => 'bail|required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1])){
            if(auth()->user()->role->role == 'superadmin'){
                $request->session()->put('clientes', Client::all());
                return redirect()->route('elegir_cliente');
            }
            
            return redirect()->route('kpi');
        }
        return back()
            ->withErrors(['email' => 'Las credenciales no coinciden con los registros'])
            ->withInput(request(['email']));
    }

    public function showNuevoUsuarioForm(){
        $active = ['maestros','usuarios'];
        return view('maestros.register')->with('active',$active);
    }

    public function logout(){
        Auth::logout();
        session()->flush();
        return redirect('/');
    }

    public function registrarUsuario(Request $request){
        $credentials = $this->validate($request,[
            'email' => 'bail|email|required|string|unique:users',
            'username' => 'bail|required|string',
            'password' => 'required|string',
            'role' => 'required'
        ]);
        $newUser = new User();
        
        $newUser->email = $request->email;
        $newUser->username = $request->username;
        $newUser->password = Hash::make($request->password);
        if(session()->has('clienteElegido')){
            $newUser->client_id = session('clienteElegido')->id;
        }else{
            $newUser->client_id = auth()->user()->client->id;
        }
        $roles = Role::all();
        foreach ($roles as $role) {
            if($role->role === $request->role){
                $newUser->role_id = $role->id;
            break;
            }
        }
        $newUser->save();
        return redirect()->route('usuarios');
    }

    public function showEditarUsuarioForm(Request $request){
        $active = ['maestros','usuarios'];
        if($request->email){
            $user = User::where('email', $request->email)->get()->first();
        }else{
            $user = auth()->user();
        }
        return view('maestros.editarUsuario')->with('user', $user)
                                            ->with('active',$active);
    }

    public function editarUsuario(Request $request){
        $user = User::where('email', $request->old_email)->get()->first();
        $user->email = $request->email;
        $user->username = $request->username;
        $roles = Role::all();
        foreach ($roles as $role) {
            if($role->role === $request->role){
                $user->role_id = $role->id;
            break;
            }
        }
        $user->save();
        return redirect()->route('usuarios');
    }

    public function cambiarEstadoUsuario(Request $request){
        $user = User::where('email',$request->email)->get()->first();
        $user->active = !$user->active;
        $user->save();
        return redirect()->back();
    }

    public function showReestablecerForm(Request $request){
        $active = ['maestros','usuarios'];
        $user = User::where('email', $request->email)->get()->first();
        return view('maestros.reestablecer')->with('active',$active)
                                                        ->with('user',$user);
    }

    public function reestablecerPassword(Request $request){
        $user = User::where('email',$request->email)->get()->first();
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('usuarios');
    }

    public function obtenerTodosLosUsuarios(){
        if(session()->has('clienteElegido')){
            $users = User::where('client_id',session('clienteElegido')->id)->get();
        }else{
            $users = auth()->user()->client->user;
        }
        return $users;
    }
}
