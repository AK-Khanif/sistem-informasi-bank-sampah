<?php

namespace App\Policies;

use App\Models\User;

class CollectorPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view collectors');
    }

    public function view(User $user): bool
    {
        return $user->hasPermissionTo('view collectors');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create collectors');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update collectors');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete collectors');
    }

    public function restore(User $user): bool
    {
        return false;
    }

    public function forceDelete(User $user): bool
    {
        return false;
    }
}
