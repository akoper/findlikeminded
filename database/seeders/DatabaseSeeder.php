<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Andrew Koper',
            'password' => Hash::make('asdfasdf'),
            'email' => 'andrew.koper@gmail.com',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'password' => Hash::make('asdfasd'),
            'email' => 'test@example.com',
        ]);

        User::factory(10)->create();
        \App\Models\User::factory(10)->create();
        \App\Models\Group::factory(20)->create();
    }
}
