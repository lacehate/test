<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::firstOrCreate([
            'name' => 'post news',
        ]);
        Permission::firstOrCreate([
            'name' => 'create news',
        ]);
        Permission::firstOrCreate([
            'name' => 'delete news',
        ]);
        Permission::firstOrCreate([
            'name' => 'read news',
        ]);

        $admin = Role::where('name', 'admin')->firstOrFail();
        $admin->givePermissionTo([
            'post news',
            'create news',
            'delete news',
            'read news',
        ]);

        $admin = Role::where('name', 'guest')->firstOrFail();
        $admin->givePermissionTo([
            'read news',
        ]);
    }
}
