<?php

namespace App\Filament\Operator\Pages\Auth;

class Login extends \Filament\Auth\Pages\Login
{
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email' => $data['email'],
            'password' => $data['password'],
            'status' => true,
        ];
    }
}
