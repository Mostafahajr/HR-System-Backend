<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Privilege;

class PrivilegeSeeder extends Seeder
{
    public function run()
    {
        $pageNames = ['Users','Employees','Groups_and_Permissions','Salary_Related_Settings','Weekend_Settings','Official_Holidays','Attendance_Reports','Salaries','Departments'];
        $operations = ['create', 'read', 'update', 'delete'];

        foreach ($pageNames as $pageName) {
            foreach ($operations as $operation) {
                Privilege::create([
                    'page_name' => $pageName,
                    'operation' => $operation,
                ]);
            }
        }
    }
}
