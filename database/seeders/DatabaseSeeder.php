<?php

namespace Database\Seeders;

use App\Enum\UserRoleEnum;
use App\Models\AdminGroup;
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

        $user1 = User::factory()->create([
            'name' => 'Andrew Koper',
            'password' => Hash::make('asdfasdf'),
            'email' => 'andrew.koper@gmail.com',
        ]);

        $user2 = User::factory()->create([
            'name' => 'Test User #1',
            'password' => Hash::make('asdfasdf'),
            'email' => 'test1@example.com',
        ]);

        $user3 = User::factory()->create([
            'name' => 'Test User #2',
            'password' => Hash::make('asdfasdf'),
            'email' => 'test2@example.com',
        ]);

        $user4 = User::factory()->create([
            'name' => 'Test User #3',
            'password' => Hash::make('asdfasdf'),
            'email' => 'test@example.com',
        ]);

        // group #1
        $group1 = Group::factory()->create([
            'name' => 'Detroit JavaScript',
            'description' => 'Detroit JavaScript',
        ]);

        // group #2
        $group2 = Group::factory()->create([
            'name' => 'Detroit PHP',
            'description' => 'Detroit PHP',
        ]);

        $user1->groups()->attach($group1, ['role'=>UserRoleEnum::ADMIN]);
        $user1->groups()->attach($group2, ['role'=>UserRoleEnum::ADMIN]);
        $user2->groups()->attach($group1, ['role'=>UserRoleEnum::MEMBER]);
        $user2->groups()->attach($group2, ['role'=>UserRoleEnum::MEMBER]);
        $user3->groups()->attach($group1, ['role'=>UserRoleEnum::MEMBER]);
        $user3->groups()->attach($group2, ['role'=>UserRoleEnum::MEMBER]);
        $user4->groups()->attach($group1, ['role'=>UserRoleEnum::ADMIN]);
        $user4->groups()->attach($group2, ['role'=>UserRoleEnum::MEMBER]);

        $users = User::factory(10)->create();
        $this->command->info('User table seeded');

        $groups = Group::factory(30)->create();
        $this->command->info('Group table seeded');

        foreach($users as $user) {
            foreach($groups as $group) {
                $user->groups()->attach($group, ['role'=>UserRoleEnum::MEMBER]);
            }
        }
        $this->command->info('GroupUser table seeded - all remaining users added to all groups as members');

        Event::factory(25)->create();
        $this->command->info('Event table seeded');

        // the Location table is 'seeded'/populated with cities from the create_locations_migration
        // because --seed doesn't run in the Forge deployment script on the prod server
        $this->command->info('Location table is populated with cities in its migration file');
    }
}
