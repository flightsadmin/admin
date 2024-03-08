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

        $permissions = [
            'viewRole', 'createRole', 'editRole', 'deleteRole',
            'viewPermission', 'createPermission', 'editPermission', 'deletePermission',
            'viewUser', 'createUser', 'editUser', 'deleteUser',
            'viewSchedule', 'createSchedule', 'editSchedule', 'deleteSchedule',
         ];
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }

         // create roles and assign created permissions
         $roles = [
            [
                'name' => 'user',
                'permissions' => ['viewSchedule'],
            ],
            [
                'name' => 'admin',
                'permissions' => ['viewSchedule', 'createSchedule'],
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
                'name'              => ucwords(explode('-', $roleData['name'])[0]).' User',
                'email'             => $roleData['name'].'@flightadmin.info',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(30),
                'phone'             => '+2547000000'. $key,
                'title'             => 'Developer',
                'photo'             => 'users/noimage.jpg',
            ])->assignRole($role);
        }
    }
}