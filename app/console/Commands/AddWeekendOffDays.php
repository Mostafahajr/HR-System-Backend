<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OffDay;
use App\Models\OffDayType;
use App\Models\VacationDay;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AddWeekendOffDays extends Command
{
    protected $signature = 'offdays:add-weekends';
    protected $description = 'Add weekend off days for the current and next week';

    public function handle()
    {
        $this->info('Starting to process weekend off days...');

        $weekendType = OffDayType::firstOrCreate(
            ['name' => 'weekend'],
            ['description' => 'Regular weekend day off']
        );

        $vacationDays = VacationDay::pluck('weekend_day')->map(function ($day) {
            return strtolower($day);
        })->toArray();

        $today = Carbon::today();
        $nextSaturday = $today->copy()->next(Carbon::SATURDAY);
        $currentWeekEnd = $nextSaturday->copy()->subDay();
        $nextWeekEnd = $nextSaturday->copy()->addDays(6);

        // Check if current week has any weekend off days
        $currentWeekWeekends = OffDay::whereBetween('date', [$today, $currentWeekEnd])
            ->whereHas('offDayTypes', function ($query) use ($weekendType) {
                $query->where('off_day_types.id', $weekendType->id);
            })
            ->count();

        if ($currentWeekWeekends === 0) {
            $this->addWeekendOffDays($today, $nextSaturday, $vacationDays, $weekendType);
        }

        // Remove existing weekend off days for next week
        $this->removeExistingWeekends($nextSaturday, $nextWeekEnd, $weekendType);

        // Add new weekend off days for next week
        $this->addWeekendOffDays($nextSaturday, $nextWeekEnd->addDay(), $vacationDays, $weekendType);

        $this->info('Weekend off days have been processed successfully.');
    }

    private function addWeekendOffDays($start, $end, $vacationDays, $weekendType)
    {
        $currentDate = $start->copy();
        while ($currentDate < $end) {
            if (in_array(strtolower($currentDate->englishDayOfWeek), $vacationDays)) {
                $offDay = OffDay::firstOrCreate(
                    ['date' => $currentDate->toDateString()],
                    ['description' => 'Weekend']
                );

                if (!$offDay->offDayTypes()->where('off_day_types.id', $weekendType->id)->exists()) {
                    $offDay->offDayTypes()->attach($weekendType->id);
                }
            }
            $currentDate->addDay();
        }
    }

    private function removeExistingWeekends($start, $end, $weekendType)
    {
        $offDaysToUpdate = OffDay::whereBetween('date', [$start, $end])
            ->whereHas('offDayTypes', function ($query) use ($weekendType) {
                $query->where('off_day_types.id', $weekendType->id);
            })
            ->get();

        foreach ($offDaysToUpdate as $offDay) {
            $offDay->offDayTypes()->detach($weekendType->id);
            
            if ($offDay->offDayTypes()->count() === 0) {
                $offDay->delete();
            }
        }
    }
}