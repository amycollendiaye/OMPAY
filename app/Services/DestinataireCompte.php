<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Distributeur;
use Illuminate\Validation\ValidationException;

class DestinataireCompte
{
    /**
     * Résout le compte destinataire selon le type.
     */
    public function resolveRecipient(string $recipient, string $type)
    {
        return match ($type) {
            'telephone' => $this->resolveByTelephone($recipient),
            'code_marchand' => $this->resolveByCodeMarchand($recipient),
            default => throw ValidationException::withMessages([
                'type' => 'Type de destinataire invalide.'
            ]),
        };
    }

    public function resolveByTelephone(string $telephone)
    {
        $client = Client::where('telephone', $telephone)->first();
        if ($client?->compte) {
            return $client->compte;
        }

        $distributeur = Distributeur::where('telephone', $telephone)->first();
        if ($distributeur?->compte) {
            return $distributeur->compte;
        }

        throw ValidationException::withMessages([
            'recipient' => 'Destinataire introuvable.'
        ]);
    }

    private function resolveByCodeMarchand(string $codeMarchand)
    {
        $distributeur = Distributeur::where('code_marchand', $codeMarchand)->first();

        if (!$distributeur?->compte) {
            throw ValidationException::withMessages([
                'recipient' => 'Distributeur introuvable ou sans compte.'
            ]);
        }

        return $distributeur->compte;
    }
    public function resolveRecipientEntity(string $recipient, string $type)
{
    if ($type === 'telephone') {
        return Client::where('telephone', $recipient)->first()
            ?? Distributeur::where('telephone', $recipient)->first();
    }

    if ($type === 'code_marchand') {
        return Distributeur::where('code_marchand', $recipient)->first();
    }

    return null;
}

}
