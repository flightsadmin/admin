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
            'ManageStudents', 'ManageTeachers', 'ManageParents', 'ManageSchool',
         ];
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }

         // create roles and assign created permissions
         $roles = [
            [
                'name' => 'guest',
                'permissions' => [],
            ],
            [
                'name' => 'user',
                'permissions' => [],
            ],
            [
                'name' => 'admin',
                'permissions' => ['ManageStudents'],
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
                'phone'             => '+25470000000'. $key,
                'title'             => ucfirst($roleData['name']),
                'photo'             => 'users/noimage.jpg',
            ])->assignRole($role);
        }
    }
}