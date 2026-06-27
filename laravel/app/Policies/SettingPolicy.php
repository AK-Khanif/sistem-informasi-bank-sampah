<?php

namespace App\Policies;

use App\Models\User;

class SettingPolicy
{
    public function view(User $user): bool
    {
        return $user->hasPermissionTo('view settings');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update settings');
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function delete(User $user): bool
    {
        return false;
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
