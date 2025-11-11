<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\Compte;
use Illuminate\Auth\Access\Response;

class ComptePolicy
{
    /**
     * Determine whether the user can view any models.
     */


    public function transfer(Client $client, Compte $compte): bool
    {
        // vérifier que ce compte appartient au client
        return $compte->client_id === $client->id;
    }

    public function pay(Client $client, Compte $compte): bool
    {
        return $compte->client_id === $client->id;
    }
    public function showSolde(Client $client, Compte $compte): bool
    {
        return $compte->client_id === $client->id;
    }

    public function viewTransaction(Client $client, Compte $compte): bool
    {
        // vérifier que ce compte appartient au client
        return $compte->client_id === $client->id;
    }

    //    public function viewAny(Client $client): bool
    //     {
    //         //
    //     }

    /**
     * Determine whether the user can view the model.
     */
    // public function view(Client $client, Compte $compte): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can create models.
    //  */
    // public function create(Client $client): bool
    // {
    //     //
    // }

    /**
 * Determine whether the user can update the model.
 */
    // public function update(Client $client, Compte $compte): bool
    // {
    //     //
    // }

    /**
 * Determine whether the user can delete the model.
 */
    // public function delete(Client $client, Compte $compte): bool
    // {
    //     //
    // }

    /**
 * Determine whether the user can restore the model.
 */
    // public function restore(Client $client, Compte $compte): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(Client $client, Compte $compte): bool
    // {
    //     //
    // }
}
