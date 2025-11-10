<?php
namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PasswordService
{
    public function generateTemporaryPassword(): string
    {
        return Str::random(10);
    }

    public function hashPassword(string $password): string
    {
        return Hash::make($password);
    }
}