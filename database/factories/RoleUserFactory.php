<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleUserFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Get all existing user and role IDs
        $userIds = User::pluck('id')->toArray();
        $roleIds = Role::pluck('id')->toArray();

        return [
            'role_id' => $roleIds[array_rand($roleIds)], // Pick a random role ID
            'user_id' => $userIds[array_rand($userIds)], // Pick a random user ID
        ];
    }
}
