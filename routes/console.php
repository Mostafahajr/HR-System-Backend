<?php

use App\Console\Commands\AddWeekendOffDays;
use App\Http\Controllers\AddNewAttendanceController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('offdays:add-weekends', function () {
    $addWeekendOffDays = new AddWeekendOffDays();
    $addWeekendOffDays->handle();
    $this->info('Weekend off days have been added for next week successfully.');
})->purpose('Add weekend off days for the current and next week')->dailyAt('21:01');

Artisan::command('attendance:create-daily-records', function () {
    $controller = new AddNewAttendanceController(); // Assuming this does not require parameters
    $controller->bulkCreate();
    $this->info('Daily attendance records for today was created successfully.');
})->purpose('Create daily attendance records')->dailyAt('21:01');
