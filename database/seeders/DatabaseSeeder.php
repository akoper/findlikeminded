<?php

namespace Database\Seeders;

use App\Enum\UserRoleEnum;
use App\Models\Event;
use App\Models\Group;
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

        $groups = Group::factory(20)->create();
        $this->command->info('Group table seeded');

        foreach($users as $user) {
            foreach($groups as $group) {
                $user->groups()->attach($group, ['role'=>UserRoleEnum::MEMBER]);
            }
        }
        $this->command->info('GroupUser table seeded');

        // event #1
        $event1 = Event::factory()->create([
            'name' => 'Coffee Shop Coding Session',
            'description' => 'Bring your laptop to the Coffee Shop for a coding session.',
            'location' => 'Starbucks',
            'address' => '75648 Michigan Ave, Dearborn, MI 48134',
            'start_date' => '2025-10-10',
            'start_time' => fake()->time(),
            'end_date' => fake()->date(),
            'end_time' => fake()->time(),
            'group_id' => 2,
            'creator_id' => 1
        ]);

        // event #2
        $event2 = Event::factory()->create([
            'name' => 'Hear Bill Gates Talk',
            'description' => 'Gates will talk about the future of Microsoft.  Gates will talk about the Gates Foundation.',
            'location' => 'NewLab',
            'address' => '5600 Michigan Ave, Detroit, MI 48134',
            'start_date' => '2024-12-12',
            'start_time' => fake()->time(),
            'end_date' => fake()->date(),
            'end_time' => fake()->time(),
            'group_id' => 1,
            'creator_id' => 1
        ]);

        // event #3
        $event3 = Event::factory()->create([
            'name' => 'Drum Circle',
            'description' => 'Bring your bongos. Bring your snares.',
            'location' => 'Capitol Park',
            'address' => '1300 Woodward Ave, Detroit, MI 48134',
            'start_date' => '2025-12-12',
            'start_time' => fake()->time(),
            'end_date' => fake()->date(),
            'end_time' => fake()->time(),
            'group_id' => 1,
            'creator_id' => 1
        ]);

        $user1->events()->attach($event1);
        $user1->events()->attach($event2);
        $user1->events()->attach($event3);
        $user2->events()->attach($event1);
        $user2->events()->attach($event2);
        $user2->events()->attach($event3);
        $user3->events()->attach($event1);
        $user3->events()->attach($event3);
        $user4->events()->attach($event1);
        $user4->events()->attach($event2);
        $user4->events()->attach($event3);

        $this->command->info('EventUser table seeded');

        Event::factory(25)->create();
        $this->command->info('Event table seeded');

        // the Location table is 'seeded'/populated with cities from the create_locations_migration
        // because --seed doesn't run in the Forge deployment script on the prod server
        $this->command->info('Location table is populated with cities in its migration file');
    }
}
