<?php

namespace App\Policies;

use App\Models\User;

class WastePricePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view waste-prices');
    }

    public function view(User $user): bool
    {
        return $user->hasPermissionTo('view waste-prices');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create waste-prices');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update waste-prices');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete waste-prices');
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
