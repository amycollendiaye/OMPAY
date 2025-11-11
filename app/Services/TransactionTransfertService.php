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

        return DB::transaction(function () use ($emetteur, $recepteur, $montant) {
            // Débit émetteur
            Transaction::create([
                'compte_id' => $emetteur->id,
                'type' => 'transfert_sortant',
                'montant' => $montant,
            ]);

            // Crédit destinataire
            Transaction::create([
                'compte_id' => $recepteur->id,
                'type' => 'transfert_entrant',
                'montant' => $montant,
            ]);

            return true;
        });
    }

 }