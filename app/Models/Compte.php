<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Compte extends Model
{
    use HasFactory;
    protected $fillable = [
        "numero_compte",
        "type",
        "statut",
        "date_creation",
        "plafond",
        "client_id",
        "distributeur_id"
    ];
    public $incrementing = false;

    // Type de clé
    protected $keyType = 'string';


    public function client()
    {
        return  $this->belongsTo(Client::class, "client_id");
    }

    public function distributeur()
    {
        return $this->belongsTo(Distributeur::class, 'distributeur_id');
    }

    public function  transactionEmises()
    {
        return $this->hasMany(Transaction::class, 'compte_emetteur_id');
    }
    public function  transactionrecus()
    {
        return $this->hasMany(Transaction::class, 'compte_beneficiaire_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'compte_emetteur_id')
            ->orWhere('compte_beneficiaire_id', $this->id);
    }

    public function getSoldeAttribute()
    {
        $initial = 500000;

        // Débits : sommes des transactions où ce compte est émetteur
        $totalDebit = $this->transactionEmises()
            ->whereIn('type', ['paiement', 'transfert'])
            ->where('statut', 'valide')
            ->where('archive', false)
            ->sum('montant');

        // Crédits : sommes des transactions où ce compte est bénéficiaire
        $totalCredit = $this->transactionrecus()
            ->whereIn('type', ['paiement', 'transfert'])
            ->where('statut', 'valide')
            ->where('archive', false)
            ->sum('montant');

        return $initial - $totalDebit + $totalCredit;
    }
}
