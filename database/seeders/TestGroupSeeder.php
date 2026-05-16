<?php

namespace Database\Seeders;

use App\Models\TestGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TestGroup::create([
            'name' => 'Metal'
        ]);
    }
}
