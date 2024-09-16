<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        $this->call([
            DepartmentSeeder::class,
            EmployeeSeeder::class,
            GroupTypeSeeder::class,
            PrivilegeSeeder::class,
            GroupPriviledgeSeeder::class,
            UserSeeder::class,
            VacationDaySeeder::class,
            OffDaySeeder::class,
            AttendanceSeeder::class,
            HourRuleSeeder::class,
        ]);
    }
}
