<?php

namespace App\Http\Middleware;

use Closure;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        foreach(auth()->user()->role->task as $permiso){
            if($permiso->task == $request->path()){
                return $next($request);
            }
        }
        return redirect()->back()->withError('Permiso', 'No tiene permisos para realizar esta accion');
    }
}
