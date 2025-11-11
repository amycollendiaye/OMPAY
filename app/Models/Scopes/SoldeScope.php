<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SoldeScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->withSum('transactions as total_debit', 'montant', function ($query) use ($model) {
            $query->where(function ($q) use ($model) {
                $q->where('type', 'paiement')
                    ->orWhere(function ($q2) use ($model) {
                        $q2->where('type', 'transfert')
                            ->where('compte_emetteur_id', $model->id);
                    });
            });
        });

        $builder->withSum('transactions as total_credit', 'montant', function ($query) use ($model) {
            $query->where('type', 'transfert')
                ->where('compte_beneficiare_id', $model->id);
        });
    }
}
