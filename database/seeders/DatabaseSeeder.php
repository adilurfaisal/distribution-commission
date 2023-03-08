<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\Rules;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Rules::factory()->create([
            'name' => 'Admin',
        ]);
        Rules::factory()->create([
            'name' => 'Affiliate',
        ]);
        Rules::factory()->create([
            'name' => 'Sub–Affiliate',
        ]);
        Rules::factory()->create([
            'name' => 'Normal User',
        ]);

        User::factory()->create([
            'name' => 'Adil',
            'email' => 'adil@gmail.com',
            'password' => Hash::make("adil"),
            'rule_id' => 1,
        ]);
        
    }
}
