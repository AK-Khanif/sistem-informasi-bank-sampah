<?php

namespace App\Policies;

use App\Models\User;

class WasteCategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view waste-categories');
    }

    public function view(User $user): bool
    {
        return $user->hasPermissionTo('view waste-categories');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create waste-categories');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update waste-categories');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete waste-categories');
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
