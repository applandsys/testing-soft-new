<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['name' => 'Iron (Fe)'],
            ['name' => 'Aluminum (Al)'],
            ['name' => 'Titanium (Ti)'],
            ['name' => 'Manganese (Mn)'],
            ['name' => 'Chromium (Cr)'],
            ['name' => 'Nickel (Ni)'],
            ['name' => 'Cobalt (Co)'],
            ['name' => 'Zinc (Zn)'],
            ['name' => 'Copper (Cu)'],
            ['name' => 'Lead (Pb)'],
            ['name' => 'Lithium (Li)'],
            ['name' => 'Vanadium (V)'],
            ['name' => 'Calcium (Ca)'],
            ['name' => 'Magnesium (Mg)'],
            ['name' => 'Sodium (Na)'],
            ['name' => 'Potassium (K)'],
            ['name' => 'Silicon (Si)'],
            ['name' => 'Zirconium (Zr)'],
            ['name' => 'Uranium (U)'],
            ['name' => 'Thorium (Th)'],
        ];

        $data = [];

        foreach ($items as $item) {
            $data[] = [
                'test_group_id' => 1,
                'name' => $item['name'],
                'length' => rand(50, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('test_items')->insert($data);
    }
}
