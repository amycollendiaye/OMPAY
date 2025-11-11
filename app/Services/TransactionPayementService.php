<?php

namespace App\Services;

use App\Models\Compte;
use App\Models\Distributeur;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransactionPayementService
{
    protected DestinataireCompte $resolver;

    public function __construct(DestinataireCompte $resolver)
    {
        $this->resolver = $resolver;
    }

    ///  je doit gerer le principe de RSP
    private function VerifSolde(Compte $sender, float $montant): void
    {



        if ($sender->solde < $montant) {
            throw ValidationException::withMessages([
                'solde' => 'Solde insuffisant.'
            ]);
        }
    }
    // Effectue un paiement d’un compte émetteur vers un compte destinataire.

    public function payRecipient(Compte $sender, string $recipient, float $montant, string $type): void
    {
        $this->VerifSolde($sender, $montant);

        $recipientCompte = $this->resolver->resolveRecipient($recipient, $type);


        $this->executeTransaction($sender, $recipientCompte, $montant, $type, $recipient);
    }

    //     * Exécute la transaction dans une transaction DB.

    private function executeTransaction(Compte $sender, Compte $recipientCompte, float $montant, string $type, string $recipient): void
    {
        DB::transaction(function () use ($sender, $recipientCompte, $montant, $type, $recipient) {
            Transaction::create([
                'compte_emetteur_id' => $sender->id,
                'compte_beneficiaire_id' => $recipientCompte->id,
                'type' => 'paiement',
                'montant' => $montant,
                'code_marchand' => $type === 'code_marchand' ? $recipient : null,
            ]);
        });
    }
    public function payAndGetDetails(Compte $sender, string $recipient, float $montant, string $type): array
{
    $soldeAvant = $sender->solde;

    $this->payRecipient($sender, $recipient, $montant, $type);

    $transaction = \App\Models\Transaction::where('compte_emetteur_id', $sender->id)
        ->where('type', 'paiement')
        ->latest()
        ->first();

    $soldeApres = $sender->fresh()->solde;

    $destinataire = $this->resolver->resolveRecipientEntity($recipient, $type);

    return [
        'client' => $sender->user,
        'solde_avant' => $soldeAvant,
        'solde_apres' => $soldeApres,
        'transaction' => $transaction,
        'destinataire' => $destinataire,
        'type' => $type,
    ];
}

}
