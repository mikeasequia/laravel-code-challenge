<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PolicyRule;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user
        User::factory()->create([
            'name' => 'Staff User',
            'email' => 'staff@example.com',
            'role' => 'staff',
            'email_verified_at' => now(),
        ]);

        // Create a test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Rule for form submission
        PolicyRule::create([
            'action' => 'submit_form',
            'name' => 'Form Submission Policy',
            'description' => 'Only verified staff can submit forms',
            'rules' => [
                ['field' => 'role', 'operator' => '==', 'value' => 'staff'],
                ['field' => 'email_verified_at', 'operator' => 'is_not_null', 'value' => null]
            ]
        ]);
    }
}
