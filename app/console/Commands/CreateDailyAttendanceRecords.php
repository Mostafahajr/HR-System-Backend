<?php

namespace App\Console\Commands;

use App\Http\Controllers\AddNewAttendanceController;
use Illuminate\Console\Command;

class CreateDailyAttendanceRecords extends Command
{
    protected $signature = 'attendance:create-daily-records';
    protected $description = 'Create daily attendance records for all employees';

    public function handle(AddNewAttendanceController $controller)
    {
        $controller->bulkCreate();
        $this->info('Daily attendance records created successfully.');
    }
}
