<?php

namespace App\Observers;

use App\Models\Distributeur;
use Illuminate\Support\Str;


class DistributeurObserver
{
    /**
     * Handle the Distributeur "created" event.
     */

    public function creating(Distributeur $distributeur): void
    {
        if (empty($distributeur->id)) {
            $distributeur->id = (string) Str::uuid();
        }
         // Génération du code marchand unique
        if (empty($distributeur->code_marchand)) {
            do {
                $code = 'CM-' . strtoupper(Str::random(6)); // Exemple : CM-AZ3K8D
            } while (Distributeur::where('code_marchand', $code)->exists());

            $distributeur->code_marchand = $code;
        }

    
    }

    public function created(Distributeur $distributeur): void
    {
        // Créer un compte pour le distributeur
        \App\Models\Compte::create([
            'type' => 'distributeur',
            'statut' => 'actif',
            'date_creation' => now()->toDateString(),
            'plafond' => false,
            'distributeur_id' => $distributeur->id,
        ]);
    }

    /**
     * Handle the Distributeur "updated" event.
     */

    /**
     * Handle the Distributeur "deleted" event.
     */
    public function deleted(Distributeur $distributeur): void
    {
        
    }

    /**
     * Handle the Distributeur "restored" event.
     */
    public function restored(Distributeur $distributeur): void
    {
        //
    }

    /**
     * Handle the Distributeur "force deleted" event.
     */
    public function forceDeleted(Distributeur $distributeur): void
    {
        //
    }
}
