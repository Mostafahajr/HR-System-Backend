<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HourRule;

class HourRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert penalty record (deduction)
        HourRule::create([
            'type' => 'deduction',
            'hour_amount' => 2,
        ]);

        // Insert bonus record (increase)
        HourRule::create([
            'type' => 'increase',
            'hour_amount' => 2,
        ]);
    }
}
