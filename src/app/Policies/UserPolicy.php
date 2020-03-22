<?php

namespace App\Policies;

use App\User;

class UserPolicy extends Policy
{
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    public function view(User $user, User $userSelect)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }
}
