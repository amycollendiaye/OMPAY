<?php

namespace App\Observers;

use App\Models\Transaction;
use Illuminate\Support\Str;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function creating(Transaction $transaction): void
    {
        if (empty($transaction->id)) {
            $transaction->id = (string) Str::uuid();
        }

        if (empty($transaction->numero_reference)) {
            do {
                $numero = 'OMPAY-' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
            } while (Transaction::where('numero_reference', $numero)->exists());

            $transaction->numero_reference = $numero;
        }
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //
    }
}
