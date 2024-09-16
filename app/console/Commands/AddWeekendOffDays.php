<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OffDay;
use App\Models\OffDayType;
use App\Models\VacationDay;
use Carbon\Carbon;

class AddWeekendOffDays extends Command
{
    protected $signature = 'offdays:add-weekends';
    protected $description = 'Add weekend off days for the next 30 days';

    public function handle()
    {
        $weekendType = OffDayType::firstOrCreate(
            ['name' => 'weekend'],
            ['description' => 'Regular weekend day off']
        );

        $vacationDays = VacationDay::pluck('weekend_day')->map(function ($day) {
            return strtolower($day);
        });

        $startDate = Carbon::today();
        $endDate = $startDate->copy()->addDays(30);

        while ($startDate <= $endDate) {
            if ($vacationDays->contains(strtolower($startDate->englishDayOfWeek))) {
                $offDay = OffDay::firstOrCreate(
                    ['date' => $startDate->toDateString()],
                    ['description' => 'Weekend']
                );

                $offDay->offDayTypes()->syncWithoutDetaching([$weekendType->id]);
            }
            $startDate->addDay();
        }

        $this->info('Weekend off days have been added successfully.');
    }
}