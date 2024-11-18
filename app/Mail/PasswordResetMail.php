<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    /**
     * Cria uma nova instância de mensagem.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Constrói o e-mail.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.password_reset')
                    ->with(['code' => $this->token]); // Passa o token para a view
    }
}
