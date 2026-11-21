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
            'name' => 'Lab Incharge',
            'email' => 'labs@iaea.com',
            'password' => Hash::make('Test@999'), // change in production
            'slug' => 'positive',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Max',
            'email' => 'labn@iaea.com',
            'password' => Hash::make('Test@999'),
            'slug' => 'negative',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Mega X',
            'email' => 'labp@iaea.com',
            'password' => Hash::make('Test@999'),
            'slug' => 'pause',
            'email_verified_at' => now(),
        ]);

    }
}
