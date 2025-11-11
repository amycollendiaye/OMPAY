<?php
namespace App\Services;

use App\Models\Compte;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransactionTransfertService {
    public function transfert(Compte $emetteur, Compte $recepteur, float $montant)
    {
        if ($emetteur->solde < $montant) {
            throw ValidationException::withMessages(['solde' => 'Solde insuffisant.']);
        }

        return Transaction::create([
            'compte_emetteur_id' => $emetteur->id,
            'compte_beneficiaire_id' => $recepteur->id,
            'type' => 'transfert',
            'montant' => $montant,
            'date_transaction' => now()->toDateString(),
            'numero_reference' => 'TXN-' . rand(100000, 999999),
            'statut' => 'en_attente'
        ]);
    }
}