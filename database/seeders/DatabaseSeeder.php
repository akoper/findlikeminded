<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $this->command->info('Specific test user and group data seeded');

        User::factory(10)->create();
        $this->command->info('User table seeded');
        Group::factory(30)->create();
        $this->command->info('Group table seeded');
        GroupUser::factory(50)->create();
        $this->command->info('GroupUser table seeded');
        Event::factory(25)->create();
        $this->command->info('Event table seeded');

        // the Location table is 'seeded' from the create_locations_migration file
        // because --seed doesn't run in the Forge deployment script on the prod server
        $this->command->info('Location table is populated with cities in its migration file');
    }
}
