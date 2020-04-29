<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function login(Request $request){
        $credentials = $this->validate($request, [
            'email' => 'bail|required|email|string'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1])){
            return redirect()->route('kpi');
        }
        return back()
            ->withErrors(['email' => 'Las credenciales no coinciden con los registros'])
            ->withInput(request(['email']));
    }

    public function showRegistrationForm(){
        return view('register');
    }

    public function logout(){
        Auth::logout();

        return redirect('/');
    }

    public function register(Request $request){
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
        $newUser->client_id = 1;
        $roles = Role::all();
        foreach ($roles as $role) {
            if($role->role === $request->role){
                $newUser->role_id = $role->id;
            break;
            }
        }
        $newUser->save();
    }
}
