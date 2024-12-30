<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Group;
use App\Models\GroupUser;
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
            'password' => Hash::make('asdfasdf'),
            'email' => 'test@example.com',
        ]);

        // this is test data for the group_user relationship specifically, per Mike
        // user #3
        User::factory()->create([
            'name' => 'Jason JavaScript',
            'password' => Hash::make('asdfasdf'),
            'email' => 'test1@example.com',
        ]);

        // user #4
        User::factory()->create([
            'name' => 'Phil PHP',
            'password' => Hash::make('asdfasdf'),
            'email' => 'test2@example.com',
        ]);

        // group #1
        Group::factory()->create([
            'name' => 'JavaScript',
            'description' => 'Detroit JavaScript',
        ]);

        // group #2
        Group::factory()->create([
            'name' => 'PHP',
            'description' => 'Detroit PHP',
        ]);

        GroupUser::factory()->create([
            'group_id' => 1,
            'user_id' => 3,
        ]);

        GroupUser::factory()->create([
            'group_id' => 1,
            'user_id' => 4,
        ]);

        GroupUser::factory()->create([
            'group_id' => 2,
            'user_id' => 4,
        ]);

        User::factory(10)->create();
        Group::factory(30)->create();
        GroupUser::factory(50)->create();
        Event::factory(25)->create();
    }
}
