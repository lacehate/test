<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class AdminSeeder extends Seeder
{


    public function run()
    {
        Role::create([
            'name' => 'admin'
        ]);
        Role::create([
            'name' => 'guest'
        ]);

        $user = User::query()->create([
            'name' => 'admin',
            'email' => 'super-admin@test.kz',
            'password' => Hash::make('Admin!E@')
        ]);
        $user->assignRole('admin');

        $guest = User::query()->create([
            'name' => 'guest',
            'email' => 'guest@test.kz',
            'password' => Hash::make('Guest!E@')
        ]);
        $guest->assignRole('guest');
    }
}
