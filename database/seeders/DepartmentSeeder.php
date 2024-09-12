<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        // List of department names to seed
        $departmentNames = [
            'Finance',
            'Marketing',
            'Human Resources',
            'Sales',
            'Customer Service',
            'IT Support',
            'Research and Development',
            'Legal',
            'Operations',
            'Product Management'
        ];

        foreach ($departmentNames as $name) {
            Department::create([
                'department_name' => $name,
            ]);
        }
    }
}
