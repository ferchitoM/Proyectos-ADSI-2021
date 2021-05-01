<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Roles
{
    //php artisan make:middleware Roles

    public function handle(Request $request, Closure $next, $admin, $usuario) //$otro_rol, $otro_rol2
    {
        $rol = Auth::user()->tipo;
        $verificar = array($admin, $usuario);

        if (in_array($rol, $verificar)) {
            return $next($request);
        }

        //SI ALGUN USUARIO ES NULL ENTONCES SE DEVUELVE AL INDEX
        return redirect()->route('index');
    }
}

//PERMITIR ROLES:
//->middleware(['auth', 'verified' 'Roles:admin,usuario,vendedor']) 

//PROHIBIR ROLES:
//->middleware(['auth', 'verified' 'Roles:admin,NULL,vendedor']) //AQUÍ QUEDÓ RESTRINGIDO $usuario