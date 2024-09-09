<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Attendance;
use App\Models\ModifySalary;
use App\Models\User;
use App\Models\GroupType;
use App\Models\Privilege;
use App\Models\OffDay;
use App\Models\HourRule;

use App\Models\GroupPrivilege;

class CombinedSeeder extends Seeder
{
    public function run()
    {
        // Seed departments table
        Department::factory()->count(5)->create();

        // Seed employees table
        Employee::factory()->count(10)->create();

        // Seed group_types table
        GroupType::factory()->count(5)->create();

        // Seed privileges table
        Privilege::factory()->count(10)->create();

        // Seed off_days table
        OffDay::factory()->count(10)->create();

        // Seed hour_rules table
        HourRule::factory()->count(5)->create();



        // Seed group_privilege table (after group_types and privileges)
        GroupPrivilege::factory()->count(5)->create();

        // Seed attendances table
        Attendance::factory()->count(20)->create();

        // Seed modify_salaries table
        ModifySalary::factory()->count(15)->create();

        
        Admin::factory()->count(10)->create();
    }
}
