<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
                ->from('nocontestar_recorrido@gmail.com', 'Soporte técnico RECORRIDO')
                ->greeting(Lang::get('Hola!'))
                ->subject(Lang::get('Verificación de correo electrónico'))
                ->line(Lang::get('Por favor, haga click en el botón de abajo para verificar su direccion de correo electronico'))
                ->action(Lang::get('Verificar correo electrónico'), $verificationUrl)
                ->line(Lang::get('Si no creó una cuenta, no es necesario realizar ninguna otra acción.'))
                ->salutation(new HtmlString("Saludos,<br>RECORRIDO"));
        });

        ResetPassword::toMailUsing(function ($user, string $token) {
            return (new MailMessage)
                ->from('nocontestar_recorrido@gmail.com', 'Soporte técnico RECORRIDO')
                ->greeting(Lang::get('Hola!'))
                ->subject(Lang::get('Notificación de restablecimiento de contraseña'))
                ->line(Lang::get('Recibió este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para su cuenta.'))
                ->action(Lang::get('Reestablecer contraseña'), url(route(
                    'password.reset',
                    [
                        'token' => $token,
                        'email' => $user->getEmailForPasswordReset(),
                    ],
                    false
                )))
                ->line(Lang::get('Este enlace para restablecer la contraseña caducará en 60 minutos.'))
                ->salutation(new HtmlString("Saludos,<br>RECORRIDO VIRTUAL SENA"));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Force SSL in production
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}
