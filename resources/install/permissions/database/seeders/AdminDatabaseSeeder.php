<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class AdminDatabaseSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'viewRole', 'createRole', 'editRole', 'deleteRole',
            'viewPermission', 'createPermission', 'editPermission', 'deletePermission',
            'viewUser', 'createUser', 'editUser', 'deleteUser',
            'viewFlights', 'createFlights', 'editFlights', 'deleteFlights',
            'viewRegistrations', 'createRegistrations', 'editRegistrations', 'deleteRegistrations',
            'viewAirline', 'createAirline', 'editAirline', 'deleteAirline',
            'viewSchedule', 'createSchedule', 'editSchedule', 'deleteSchedule',
         ];
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }

         // create roles and assign created permissions
        $role1 = Role::create(['name' => 'user'])->givePermissionTo(['viewFlights', 'viewRegistrations', 'viewAirline']);
        $role2 = Role::create(['name' => 'admin'])->givePermissionTo(['viewSchedule', 'createSchedule', 'viewAirline', 'createAirline','viewRegistrations', 'createRegistrations']);
        $role3 = Role::create(['name' => 'super-admin'])->givePermissionTo(Permission::all());
        
        // create User
        $user1 = User::create([
            'name'              => 'Site User',
            'email'             => 'user@flightadmin.info',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token'    => Str::random(10),
            'phone'             => '+2547000002',
            'title'             => 'Developer',
            'photo'             => 'users/noimage.jpg',
        ])->assignRole($role1);

        // create Admin
        $user2 = User::create([
            'name'              => 'Site Admin',
            'email'             => 'admin@flightadmin.info',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token'    => Str::random(10),
            'phone'             => '+2547000001',
            'title'             => 'Developer',
            'photo'             => 'users/noimage.jpg',
        ])->assignRole($role2);
        
        // create Super-admin
        $user3 = User::create([
            'name'              => 'Super Admin',
            'email'             => 'super-admin@flightadmin.info',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token'    => Str::random(10),
            'phone'             => '+2547000000',
            'title'             => 'Developer',
            'photo'             => 'users/noimage.jpg',
        ])->assignRole($role3);
    }
}