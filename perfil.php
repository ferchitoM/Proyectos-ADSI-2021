<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Aprendiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;

class perfil extends Controller
{

    //RUTA PRINCIPAL '/'
    public function index()
    {
        //SI NO HAY ADMINISTRADOR IR A REGISTRAR ADMIN
        if (Admin::get()->count() == 0) {
            return view('auth.registerAdmin');
        }

        return redirect()->route('login');
    }


    //RUTA DASHBOARD
    public function enrutarUsuario()
    {
        //SI ENCONTRÓ UN USUARIO ADMINISTRADOR IR A ADMINISTRACION
        if (Auth::user()->tipo == 'admin') {
            return redirect()->route('admin-bienestar');
        }

        //SINO IR A APP
        return redirect()->route('app-index');
    }


    //RUTA PERFIL USUARIO
    public function perfil()
    {
        $datos = Aprendiz::where('user', Auth::user()->id)->first();
        
        return view('auth.perfil', ['user' => Auth::user(), 'datos' => $datos]);
    }



    //RUTA PERFIL ADMIN
    public function perfil_admin()
    {
        $datos = Admin::where('user', Auth::user()->id)->first();
        
        return view('auth.perfil_admin', ['user' => Auth::user(), 'datos' => $datos]);
    }


    //ACTUALIZAR DATOS DEL USUARIO
    public function actualizarDatos(Request $request)
    {

        $user = User::find(Auth::user()->id);

        $reglas = [
            //'Documento' => 'required|max:20|unique:aprendiz,Documento',
            //'Documento' => 'required|max:20|unique:aprendiz,Documento',
            'email' => 'required|email|max:100|unique:users,email,'.$user->id.'|regex:/(.*)@misena\.edu.co/i', //SOLO CORREOS MISENA
        ];

        $mensajesPersonalizados = [
            //'Documento.required' => 'El documento es requerido',
            //'Documento.required' => 'El documento es requerido',
            'email.required' => 'El e-mail es obligatorio.',
            'email.unique' => 'El e-mail ya se encuentra registrado.',
            'email.max' => 'El e-mail es inválido.',
            'email.email' => 'El e-mail es inválido.',
            'email.regex' => 'Solo se permiten e-mail de dominio misena.edu.co',

        ];

        $validacion = Validator::make($request->all(), $reglas, $mensajesPersonalizados);

        if ($validacion->fails()) {
            return redirect()->back()
                ->withErrors($validacion)
                ->withInput()
                ->with('datos', ' ');
        }

        //ACTUALIZAMOS LOS DATOS NUEVOS EN USUARIO Y APRENDIZ
        $user->forceFill([
            'email' => $request->email,
        ])->save();

        $aprendiz = Aprendiz::where('user', Auth::user()->id)->first();
        $aprendiz->Correo = $request->email;
        //$aprendiz->Correo = $request->email;
        //$aprendiz->Correo = $request->email;
        $aprendiz->save();

        return redirect()->route('perfil')->with('status-datos', 'Los datos se actualizaron exitosamente!');
    }


    //ACTUALIZAR DATOS DEL USUARIO/ADMIN
    public function actualizarPassword(Request $request)
    {

        $reglas = [
            'password_vieja' => 'required',
            'password' => 'required|string|confirmed|min:8',
        ];

        $mensajesPersonalizados = [
            'password_vieja.required' => 'La contraseña actual es obligatoria.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres.',
        ];

        $validacion = Validator::make($request->all(), $reglas, $mensajesPersonalizados);

        if ($validacion->fails()) {
            return redirect()->back()
                ->withErrors($validacion)
                ->withInput()
                ->with('pass', ' ');
        }

        //SI LA CONTRASEÑA ACTUAL NO ES CORRECTA MOSTRAMOS ERROR
        if (!Hash::check($request->password_vieja, Auth::user()->password)) {
            return redirect()->back()
                ->withErrors(['La contraseña actual es incorrecta'])
                ->withInput()
                ->with('pass', ' ');
        }

        //ACTUALIZAMOS LA CONTRASEÑA EN USUARIO
        $user = User::find(Auth::user()->id);
        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));

        //SI EL USUARIO ES ADMINISTRADOR SE ENVIA A PERFIL-ADMIN
        if (Auth::user()->tipo == 'admin') {
            return redirect()->route('perfil-admin')->with('status-password', 'La contraseña se actualizó exitosamente!');
        }

        //SINO ES ADMIN SE ENVIA A PERFIL
        return redirect()->route('perfil')->with('status-password', 'La contraseña se actualizó exitosamente!');
    }



    //ACTUALIZAR DATOS DEL ADMIN
    public function actualizarDatos_admin(Request $request)
    {

        $user = User::find(Auth::user()->id);

        $reglas = [
            //'Documento' => 'required|max:20|unique:aprendiz,Documento',
            //'Documento' => 'required|max:20|unique:aprendiz,Documento',
            'email' => 'required|email|max:100|unique:users,email,'.$user->id,
        ];

        $mensajesPersonalizados = [
            //'Documento.required' => 'El documento es requerido',
            //'Documento.required' => 'El documento es requerido',
            'email.required' => 'El e-mail es obligatorio.',
            'email.email' => 'El e-mail es inválido.',
            'email.unique' => 'El e-mail ya se encuentra registrado.',
            'email.max' => 'El e-mail es inválido.',

        ];

        $validacion = Validator::make($request->all(), $reglas, $mensajesPersonalizados);

        if ($validacion->fails()) {
            return redirect()->back()
                ->withErrors($validacion)
                ->withInput()
                ->with('datos', ' ');
        }

        //ACTUALIZAMOS LOS DATOS NUEVOS EN USUARIO Y ADMINISTRADOR
        $user->forceFill([
            //'Documento' => $request->Documento,
            //'Documento' => $request->Documento,
            'email' => $request->email,
        ])->save();

        $admin = Admin::where('user', Auth::user()->id)->first();
        //$admin->Documento = $request->Documento;
        //$admin->Documento = $request->Documento;
        $admin->save();

        return redirect()->route('perfil-admin')->with('status-datos', 'Los datos se actualizaron exitosamente!');
    }
}
