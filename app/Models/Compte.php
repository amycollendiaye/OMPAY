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
        "client_id"
    ];
    public $incrementing = false;

    // Type de clé
    protected $keyType = 'string';


    public function client()
    {
        return  $this->belongsTo(Client::class, "client_id");
    }
    public function  transactionEmises()
    {
        return $this->hasMany(Compte::class, 'compte_emetteur_id');
    }
    public function  transactionrecus()
    {
        return $this->hasMany(Compte::class, 'compte_beneficiare_id');
    }
}
