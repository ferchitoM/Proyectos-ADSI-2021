<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Aprendiz;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{

    public function create()
    {
        return view('auth.register');
    }


    public function store(Request $request)
    {
        
        $reglas = [
            'email' => 'required|email|max:100|unique:users|regex:/(.*)@misena\.edu.co/i', //SOLO CORREOS MISENA
            'password' => 'required|string|confirmed|min:8',
        ];

        $mensajesPersonalizados = [
            'email.required' => 'El e-mail es obligatorio.',
            'email.unique' => 'El e-mail ya se encuentra registrado.',
            'email.max' => 'El e-mail es inválido.',
            'email.regex' => 'Solo se permiten e-mail de dominio misena.edu.co',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres.'
        ];

        $this->validate($request, $reglas, $mensajesPersonalizados);

        $user = null;
        Auth::login($user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipo' => 'aprendiz',
        ]));

        $aprendiz = new Aprendiz();
        $aprendiz->user = $user->id;
        $aprendiz->Correo = $user->email;
        $aprendiz->save();

        event(new Registered($user));

        return redirect(RouteServiceProvider::HOME);

    }


    public function crearAdmin(Request $request)
    {

        $reglas = [
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ];

        $mensajesPersonalizados = [
            'email.required' => 'El e-mail es obligatorio.',
            'email.unique' => 'El e-mail ya se encuentra registrado.',
            'email.email' => 'El e-mail es inválido.',
            'email.max' => 'El e-mail es inválido.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres.'
        ];

        $this->validate($request, $reglas, $mensajesPersonalizados);

        $user = null;
        Auth::login($user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipo' => 'admin',
        ]));

        $admin = new Admin();
        $admin->user = $user->id;
        $admin->save();

        event(new Registered($user));

        return redirect()->route('admin-bienestar');
    }

}
