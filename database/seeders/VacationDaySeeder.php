<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VacationDay;

class VacationDaySeeder extends Seeder
{
    public function run(): void
    {
        // Insert records for Friday and Saturday
        $vacationDays = [
            ['weekend_day' => 'friday'],
            ['weekend_day' => 'saturday']
        ];

        foreach ($vacationDays as $day) {
            VacationDay::create($day);
        }
    }
}
