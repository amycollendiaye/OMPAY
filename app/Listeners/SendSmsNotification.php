<?php
namespace App\Listeners;

use App\Events\CreateCompte;
use App\Services\TwilioService;
use App\Services\PasswordService;
use App\Services\TokenService;
use App\Services\QrCodeService;

class SendSmsNotification
{
    protected $twilioService;
    protected $passwordService;
    protected $tokenService;
    protected $qrCodeService;

    public function __construct(
        TwilioService $twilioService,
        PasswordService $passwordService,
        TokenService $tokenService,
        QrCodeService $qrCodeService
    ) {
        $this->twilioService = $twilioService;
        $this->passwordService = $passwordService;
        $this->tokenService = $tokenService;
        $this->qrCodeService = $qrCodeService;
    }

    public function handle(CreateCompte $event)
    {
        $client = $event->client;

        // 🔹 Mot de passe temporaire
        $passwordTemp = $this->passwordService->generateTemporaryPassword();
        $client->password = $this->passwordService->hashPassword($passwordTemp);
        $client->save();

        // 🔹 Token et lien
        $token = $this->tokenService->generateActivationToken([
            'id' => $client->id,
            'email' => $client->email,
            'telephone' => $client->telephone,
            'password_temp' => $passwordTemp,
        ]);
        $activationUrl = "https://ompay.com/activate/{$token}";

        // 🔹 QR code
        $qrCodePath = "qrcodes/client_{$client->id}.png";
        $this->qrCodeService->generateQrCode($activationUrl, $qrCodePath);
        $client->qr_code = $qrCodePath;
        $client->save();

        // 🔹 Envoi SMS
        $this->twilioService->sendSms(
            $client->telephone,
            "Bienvenue chez OM PAY 🎉 ! MR|MME {$client->nom}, activez votre compte ici : {$activationUrl}"
        );

        $this->twilioService->sendSms(
            $client->telephone,
            "Votre compte a été ajouté avec succès. Merci pour votre confiance 🙏"
        );
    }
}
