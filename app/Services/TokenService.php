<?php
namespace App\Services;

use Illuminate\Support\Facades\Crypt;

class TokenService
{
    public function generateActivationToken(array $data, int $minutes = 10): string
    {
        $data['expires_at'] = now()->addMinutes($minutes)->toIso8601String();
        return Crypt::encryptString(json_encode($data));
    }
}