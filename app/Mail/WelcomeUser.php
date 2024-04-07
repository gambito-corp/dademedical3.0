<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class WelcomeUser extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $pwd;

    public function __construct(User $user, string $pwd)
    {
        $this->user = $user;
        $this->pwd = $pwd;
    }

    public function build()
    {
        return $this
            ->subject('Bienvenido a nuestra aplicación')
            ->markdown('emails.welcome');
    }
}
