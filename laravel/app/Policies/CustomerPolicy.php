<?php

namespace App\Policies;

use App\Models\User;

class CustomerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view customers');
    }

    public function view(User $user): bool
    {
        return $user->hasPermissionTo('view customers');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create customers');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update customers');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete customers');
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
