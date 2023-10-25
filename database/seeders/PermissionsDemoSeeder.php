<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'view dynamic page']);

        Permission::create(['name' => 'view media page']);

        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo('view dynamic page');


        $moderator = Role::create(['name' => 'moderator']);
        $moderator->givePermissionTo('view media page');

        $modelUser = User::factory()->create([
            'name' => 'fta',
            'email' => 'fta@gmail.com',
            'password' => '12345678'
        ]);

        $modelUser->assignRole($user);

        $modelModerator = User::factory()->create([
            'name' => 'ara',
            'email' => 'ara@gmail.com',
            'password' => '12345678'
        ]);
        
        $modelModerator->assignRole($moderator);
    }
}