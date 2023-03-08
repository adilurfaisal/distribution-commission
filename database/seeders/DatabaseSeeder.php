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
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make("admin"),
            'rule_id' => 1,
        ]);
        User::factory()->create([
            'name' => 'Affiliate',
            'email' => 'affiliate@gmail.com',
            'password' => Hash::make("affiliate"),
            'rule_id' => 2,
            'ref_id' => 1
        ]);
        User::factory()->create([
            'name' => 'Sub Affiliate',
            'email' => 'subaffiliate@gmail.com',
            'password' => Hash::make("subaffiliate"),
            'rule_id' => 3,
            'ref_id' => 2
        ]);
        User::factory()->create([
            'name' => 'Normal',
            'email' => 'normal@gmail.com',
            'password' => Hash::make("normal"),
            'rule_id' => 4,
            'ref_id' => 3
        ]);
        User::factory()->create([
            'name' => 'Normal - Commission',
            'email' => 'normalext@gmail.com',
            'password' => Hash::make("normalext"),
            'rule_id' => 4
        ]);
        
    }
}
