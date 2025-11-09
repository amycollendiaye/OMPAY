<?php

namespace App\Models;

use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
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
