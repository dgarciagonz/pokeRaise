<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function incrementar(User $user, int $monedas): void
    {
        $user->monedas += $monedas;
        $user->save();
    }
}