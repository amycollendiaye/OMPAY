<?php 
namespace App\Services;

use App\Models\Compte;
use App\Models\Transaction;

 class TransactionService
{
    public function listTransactions(Compte $compte, array $filters)
    {
        $query = Transaction::with(['compteEmetteur.client', 'compteBeneficiaire.client', 'compteBeneficiaire.distributeur'])
            ->where(function ($q) use ($compte) {
                $q->where('compte_emetteur_id', $compte->id)
                  ->orWhere('compte_beneficiaire_id', $compte->id);
            });

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['date_debut'])) {
            $query->whereDate('date_transaction', '>=', $filters['date_debut']);
        }

        if (!empty($filters['date_fin'])) {
            $query->whereDate('date_transaction', '<=', $filters['date_fin']);
        }

        return $query->orderBy('date_transaction', 'desc');
    }
}
