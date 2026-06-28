<?php

namespace App\Policies;

use App\Models\User;

class WasteTypePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view waste-types');
    }

    public function view(User $user): bool
    {
        return $user->hasPermissionTo('view waste-types');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create waste-types');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update waste-types');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete waste-types');
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
