<?php

namespace App\Observers;

use App\Events\CreateCompte;
use App\Models\Compte;
use Illuminate\Support\Str;

class CompteObserver
{
    /**
     * Handle the Compte "created" event.
     */

        public function  creating(Compte $compte)
    {
        if (empty($compte->id)) {
            $compte->id = (string)Str::uuid();
        }

        // de numeo de compte  OMPAY
        if (empty($compte->numero_compte)) {
            // Génération d'un numéro unique
            do {
                $numero = 'OMPAY-' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
            } while (Compte::where('numero_compte', $numero)->exists());

            $compte->numero_compte = $numero;
        }
    }
   public function created(Compte $compte): void
{
    $client = $compte->client;
    
   
    event(new CreateCompte($compte, $client));
}

    /**
     * Handle the Compte "updated" event.
     */
    public function updated(Compte $compte): void
    {
        //
    }

    /**
     * Handle the Compte "deleted" event.
     */
    public function deleted(Compte $compte): void
    {
        //
    }

    /**
     * Handle the Compte "restored" event.
     */
    public function restored(Compte $compte): void
    {
        //
    }

    /**
     * Handle the Compte "force deleted" event.
     */
    public function forceDeleted(Compte $compte): void
    {
        //
    }
}
