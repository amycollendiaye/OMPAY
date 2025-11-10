<?php

namespace App\Services;

use Twilio\Rest\Client as TwilioClient;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected $client;
    protected $from;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $this->from = config('services.twilio.from');

        Log::info('TWILIO_SID: ' . $sid);
        Log::info('TWILIO_TOKEN: ' . $token);
        Log::info('TWILIO_FROM: ' . $this->from);

        // Vérifier que les credentials sont définis
        if (empty($sid) || empty($token)) {
            Log::error('Twilio credentials are not set in .env file');
            throw new \Exception('Twilio credentials are not configured');
        }

        $this->client = new TwilioClient($sid, $token);
    }

    /**
     * Envoie un SMS via Twilio
     */
    public function sendSms(string $to, string $message): bool
    {
        try {
            $this->client->messages->create($to, [
                'from' => $this->from,
                'body' => $message,
            ]);

            Log::info("📩 SMS envoyé à {$to} : {$message}");
            return true;
        } catch (\Exception $e) {
            Log::error("❌ Erreur envoi SMS Twilio : " . $e->getMessage());
            return false;
        }
    }
}
