<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GroupType;
use App\Models\Privilege;

class GroupPriviledgeSeeder extends Seeder
{
    public function run(): void
    {
        $privileges = Privilege::all();
        $pageNames = $privileges->pluck('page_name')->unique()->values();

        $accessRules = [
            'Super Admins' => $pageNames,
            'Managers' => $pageNames->slice(0, 3),
            'Supervisors' => $pageNames->slice(1, 2),
            'HR' => $pageNames->slice(2, 2),
        ];

        foreach ($accessRules as $groupName => $pages) {
            $groupType = GroupType::where('group_name', $groupName)->first();

            if (!$groupType) {
                $this->command->error("GroupType with name {$groupName} not found.");
                continue;
            }

            foreach ($pages as $pageName) {
                $privilegesForPage = $privileges->where('page_name', $pageName);

                foreach ($privilegesForPage as $privilege) {
                    $groupType->privileges()->attach($privilege->id);
                }
            }
        }
    }
}
