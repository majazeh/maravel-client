<?php

namespace App\Policies;

use App\Term;
use App\User;

class TermPolicy extends Policy
{
    public function viewAny(User $user)
    {
        if(!in_array($user->type, ['admin', 'manager', 'operator', 'psychologist']))
        {
            return false;
        }
        return true;
    }

    public function view(User $user, Term $term)
    {
        if (!in_array($user->type, ['admin', 'manager', 'operator', 'psychologist'])) {
            return false;
        }
        return true;
    }

    public function create(User $user)
    {
        if (!in_array($user->type, ['admin', 'manager', 'operator', 'psychologist'])) {
            return false;
        }
        return true;
    }
}
