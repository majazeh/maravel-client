<?php

namespace App\Policies;

use App\Term;
use App\User;

class TermPolicy extends Policy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Term $term)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }
}
