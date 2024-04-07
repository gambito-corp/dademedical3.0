<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Lang;

class CustomVerifyEmail extends VerifyEmail
{
    use Queueable;

    public string $password;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $password)
    {
        $this->password = $password;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $actionUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject(Lang::get('Verifique la dirección de correo electrónico'))
//            ->greeting($this->password) // añade la variable aquí
            ->line(Lang::get('Haga clic en el botón de abajo para verificar su dirección de correo electrónico.'))
            ->line('recuerde que su Contraseña es: '.$this->password)
            ->action(Lang::get('Verificar dirección de correo electrónico'), $actionUrl)
            ->line(Lang::get('Si no creó una cuenta, no se requiere ninguna acción adicional.'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
