<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Mega',
            'email' => 'mega@sgs.com',
            'password' => Hash::make('24434'), // change in production
            'slug' => 'positive',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Max',
            'email' => 'max@sgs.com',
            'password' => Hash::make('24434'),
            'slug' => 'negative',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Mega X',
            'email' => 'megax@sgs.com',
            'password' => Hash::make('24434'),
            'slug' => 'pause',
            'email_verified_at' => now(),
        ]);

    }
}
