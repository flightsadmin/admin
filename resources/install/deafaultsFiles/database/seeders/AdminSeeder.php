<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $actions = ["create", "edit", "view", "delete"];
        $models = ["User", "Role", "Permission", "Schedule"];

        foreach ($models as $model) {
            foreach ($actions as $action) {
                $methodName = $action . ucfirst($model);
                Permission::create(['name' => $methodName]);
            }
        }

        $roles = [
            [
                'name' => 'user',
                'permissions' => ['viewUser'],
            ],
            [
                'name' => 'admin',
                'permissions' => ['viewUser', 'createUser'],
            ],
            [
                'name' => 'super-admin',
                'permissions' => Permission::pluck('name')->toArray(),
            ],
        ];

        foreach ($roles as $key => $roleData) {
            $role = Role::create(['name' => $roleData['name']]);
            $role->givePermissionTo($roleData['permissions']);
            User::create([
                'name' => ucwords(explode('-', $roleData['name'])[0]) . ' User',
                'email' => $roleData['name'] . '@flightadmin.info',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(30),
                'phone' => '+2547000000' . $key,
                'title' => 'Developer',
                'photo' => 'users/noimage.jpg',
            ])->assignRole($role);
        }

        // Default App Setting
        foreach (config("admin.default") as $key => $value) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value],
            );
        }
    }
}