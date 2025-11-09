<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $_Fillable = [
        'type',
        "montant",
        "date_transaction",
        "numero_reference",
        'code_marchand',
        "compte_emetteur_id",
        "compte_beneficiare_id",

    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->id)) {
                $transaction->id = (string) Str::uuid();
            }
        });
    }
    public function compteEmetteur()
    {
        return $this->belongsTo(Compte::class, 'compte_emetteur_id');
    }

    public function compteBeneficiaire()
    {
        return $this->belongsTo(Compte::class, 'compte_beneficiaire_id');
    }
}
