<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        VerifyEmail::toMailUsing(function ($user, string $verificationUrl) {
            return (new MailMessage)
                ->from('nocontestar_sera@sena.edu.co', 'Soporte Tecnico SERAP')
                ->greeting(Lang::get('Hola!'))
                ->subject(Lang::get('Verificacion De correo electronico'))
                ->line(Lang::get('Por favor, haga click en el boton de abajo para verificar su direccion de correo electronico'))
                ->action(Lang::get('Verificar correo electronico'), $verificationUrl)
                ->line(Lang::get('Si no creo una cuenta, no es necesario realizar ninguna otra accion.'))
                ->salutation(new HtmlString("Saludos,<br>SERAP"));
        });

        ResetPassword::toMailUsing(function ($user, string $token) {

            return (new MailMessage)
                ->from('nocontestar_sera@sena.edu.co', 'Soporte Tecnico SERAP')
                ->greeting(Lang::get('Hola!'))
                ->subject(Lang::get('Notificacion de restablecimiento de contraseña'))
                ->line(Lang::get('Has recibido este correo electronico porque tenemos una solicitud de restablecimiento de contraseña'))
                ->action(Lang::get('Restablecer contraseña'), url(route('password.reset',
                        [
                            'token' => $token,
                            'email' => $user->getEmailForPasswordReset(),
                        ],
                        false)))
                ->line(Lang::get('El enlace para restablecer la contraseña caducara en 60 minuntos.'))
                ->salutation(new HtmlString("Saludos,<br>SERAP"));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
