<?php

namespace App\Mail;

use App\Models\Client;
use App\Models\Compte;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompteMail extends Mailable
{
    use Queueable, SerializesModels;
    public $client;
    public  $compte;


    /**
     * Create a new message instance.
     */
    public function __construct(Compte $compte, Client $client)
    {
        $this->compte = $compte;
        $this->client = $client;
    }


    public  function build()
    {
        return  $this->subject('Votre compte Orange Bank a été créé')->view('emails.compte_created');
    }


    public function content(): Content
    {
        return new Content(
            view: 'emails.compte_created',  // Utilisez la vue correcte
        );
    }


    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
