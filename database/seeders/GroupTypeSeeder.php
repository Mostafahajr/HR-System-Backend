<?php

namespace Database\Seeders;

use App\Models\GroupType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groupTypes = [
            ['group_name' => 'Super Admins'],
            ['group_name' => 'Managers'],
            ['group_name' => 'Supervisors'],
            ['group_name' => 'HR'],
        ];

        foreach ($groupTypes as $groupType) {
            GroupType::create($groupType);
        }
    }
}
