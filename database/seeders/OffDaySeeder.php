<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OffDay;
use App\Models\OffDayType;
use App\Models\VacationDay;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OffDaySeeder extends Seeder
{
    public function run(): void
    {
        // Ensure 'holiday' and 'weekend' types exist in the OffDayType table
        $holidayType = OffDayType::firstOrCreate(
            ['name' => 'holiday'],
            ['description' => 'Official and religious holidays']
        );

        $weekendType = OffDayType::firstOrCreate(
            ['name' => 'weekend'],
            ['description' => 'Regular weekend days (Friday, Saturday)']
        );

        // Array of official and religious holidays in Egypt from 09/01/2024 up to 09/01/2025
        $holidays = [
            ['date' => '2024-09-21', 'description' => 'Hijri New Year'],
            ['date' => '2024-10-06', 'description' => 'Armed Forces Day'],
            ['date' => '2024-10-15', 'description' => 'Mawlid al-Nabi'],
            ['date' => '2024-12-25', 'description' => 'Christmas Day'],
            ['date' => '2025-01-01', 'description' => 'New Year\'s Day'],
            ['date' => '2025-01-07', 'description' => 'Coptic Christmas Day'],
            ['date' => '2025-04-25', 'description' => 'Sinai Liberation Day'],
            ['date' => '2025-05-01', 'description' => 'Labour Day'],
            ['date' => '2025-07-23', 'description' => 'Revolution Day'],
            ['date' => '2025-08-19', 'description' => 'Eid al-Adha'], 
            ['date' => '2025-09-28', 'description' => 'Eid al-Fitr'], 
            ['date' => '2025-10-04', 'description' => 'Islamic New Year'],
        ];

        foreach ($holidays as $holiday) {
            // Create the OffDay record
            $offDay = OffDay::create([
                'date' => $holiday['date'],
                'description' => $holiday['description'],
            ]);

            // Insert into the off_day_off_day_type pivot table
            DB::table('off_day_off_day_type')->insert([
                'off_day_id' => $offDay->id,
                'off_day_type_id' => $holidayType->id,
            ]);
        }

        // Fetch weekend days (Friday and Saturday) from vacation_days table
        $weekendDays = VacationDay::whereIn('weekend_day', ['friday', 'saturday'])->pluck('weekend_day');

        // Define the start date and 35-day range
        $startDate = Carbon::create(2024, 9, 1);
        $endDate = $startDate->copy()->addDays(34); // 35 days span

        // Loop through each date in the 35-day span
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dayOfWeek = strtolower($date->format('l')); // Get the day of the week in lowercase

            // If the current date matches one of the weekend days and does not already exist as a holiday
            if ($weekendDays->contains($dayOfWeek)) {
                // Check if an OffDay record already exists for this date
                $existingOffDay = OffDay::where('date', $date->format('Y-m-d'))->first();

                // Skip creating a new OffDay if one already exists (likely a holiday)
                if (!$existingOffDay) {
                    // Create the OffDay record for the weekend
                    $offDay = OffDay::create([
                        'date' => $date->format('Y-m-d'),
                        'description' => ucfirst($dayOfWeek), // E.g., 'Friday', 'Saturday'
                    ]);

                    // Insert into the off_day_off_day_type pivot table for the weekend type
                    DB::table('off_day_off_day_type')->insert([
                        'off_day_id' => $offDay->id,
                        'off_day_type_id' => $weekendType->id,
                    ]);
                }
            }
        }
    }
}
