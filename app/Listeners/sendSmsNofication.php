<?php

namespace App\Listeners;

use App\Events\CompteCreated;
use App\Events\CreateCompte;
use App\Mail\CompteCreatedMail;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class sendSmsNofication
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function handle(CreateCompte $event)
    {
        Log::info('Listener SendCompteCreatedNotification appelé');
        $client = $event->client;

       
            // 🔹 Envoi Email
            // Mail::to($user->email)->send(new CompteCreatedMail($event->compte,$user));

            // 🔹 Envoi SMS de bienvenue
            $this->twilioService->sendSms(
                $client->telephone,
                "Bienvenue chez Orange Bank ! Votre compte a été créé avec succès 🎉"
            );
        
            // 🔹 Envoi SMS de confirmation
            $this->twilioService->sendSms(
                $client->telephone,
                "Votre nouveau compte a été ajouté avec succès à votre profil Orange Bank."
            );
        
    }
}
