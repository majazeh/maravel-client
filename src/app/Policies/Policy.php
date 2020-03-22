<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public function update(User $user, $model)
    {
        return $model->can('edit');
    }

    public function delete(User $user, $model)
    {
        return $model->can('delete');
    }
}
