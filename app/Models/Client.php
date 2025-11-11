<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Client extends Authenticatable
{
    use HasApiTokens, Notifiable;

    use HasFactory;
    protected $fillable = [
        "nom",
        "prenom",
        "telephone",
        "cni",
        "adresse",
        "code_secret",
        "pin_code"
    ];

    public $incrementing = false;

    // Type de clé
    protected $keyType = 'string';

    public function compte()
    {
        return $this->hasOne(Compte::class, 'client_id');
    }
}
