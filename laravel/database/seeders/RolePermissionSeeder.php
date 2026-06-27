<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $permissionNames = [
            'view users', 'create users', 'update users', 'delete users',
            'view customers', 'create customers', 'update customers', 'delete customers',
            'view waste-categories', 'create waste-categories', 'update waste-categories', 'delete waste-categories',
            'view waste-types', 'create waste-types', 'update waste-types', 'delete waste-types',
            'view waste-prices', 'create waste-prices', 'update waste-prices', 'delete waste-prices',
            'view collectors', 'create collectors', 'update collectors', 'delete collectors',
            'view deposits', 'create deposits',
            'view sales', 'create sales',
            'view cash-transactions', 'create cash-transactions',
            'view dashboard',
            'view reports', 'export reports',
            'view activity-logs',
            'view settings', 'update settings',
        ];

        $permissions = collect();
        foreach ($permissionNames as $name) {
            $permissions->push(Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']));
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions($permissions);

        $adminRw = Role::firstOrCreate(['name' => 'admin rw', 'guard_name' => 'web']);
        $adminRw->syncPermissions($permissions->filter(fn ($p) => !str_starts_with($p->name, 'view users')
            && !str_starts_with($p->name, 'create users')
            && !str_starts_with($p->name, 'update users')
            && !str_starts_with($p->name, 'delete users')));

        $petugas = Role::firstOrCreate(['name' => 'petugas', 'guard_name' => 'web']);
        $petugas->syncPermissions($permissions->filter(fn ($p) => in_array($p->name, [
            'view customers', 'create customers',
            'view deposits', 'create deposits',
            'view sales', 'create sales',
            'view cash-transactions', 'create cash-transactions',
            'view dashboard',
        ])));

        $ketuaRw = Role::firstOrCreate(['name' => 'ketua rw', 'guard_name' => 'web']);
        $ketuaRw->syncPermissions($permissions->filter(fn ($p) => in_array($p->name, [
            'view dashboard',
            'view reports', 'export reports',
        ])));
    }
}