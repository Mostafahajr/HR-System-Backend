<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GroupType;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Retrieve existing group types
        $groupTypes = GroupType::all()->keyBy('group_name');

        if ($groupTypes->isEmpty()) {
            $this->command->error('GroupTypes are missing.');
            return;
        }

        // Create specific users
        User::create([
            'name' => 'Super Admin',
            'username' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
            'group_type_id' => $groupTypes->get('Super Admins')->id,
        ]);

        User::create([
            'name' => 'Manager',
            'username' => 'Manager',
            'email' => 'manager@example.com',
            'password' => bcrypt('password'),
            'group_type_id' => $groupTypes->get('Managers')->id,
        ]);

        User::create([
            'name' => 'Supervisor',
            'username' => 'Supervisor',
            'email' => 'supervisor@example.com',
            'password' => bcrypt('password'),
            'group_type_id' => $groupTypes->get('Supervisors')->id,
        ]);

        User::create([
            'name' => 'HR One',
            'username' => 'HR One',
            'email' => 'hrone@example.com',
            'password' => bcrypt('password'),
            'group_type_id' => $groupTypes->get('HR')->id,
        ]);

        User::create([
            'name' => 'HR Two',
            'username' => 'HR Two',
            'email' => 'hrtwo@example.com',
            'password' => bcrypt('password'),
            'group_type_id' => $groupTypes->get('HR')->id,
        ]);
    }
}

