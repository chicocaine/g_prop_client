<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = \App\Models\User::factory(30)->create();
        $employees = \App\Models\Employee::factory(10)->create();
        $services = \App\Models\Service::factory(10)->create();
        $logs = \App\Models\Log::factory(10)->create();
        $attachments = \App\Models\Attachment::factory(30)->create();


        $commissions = \App\Models\Commission::factory(10)->create([
            'user_id' => function () use ($users) {
                return $users->random()->id;
            }
        ]);

        $messages = \App\Models\Message::factory(30)->create([
            'commission_id' => function () use ($commissions) {
                return $commissions->random()->id;
            },
            'user_id' => function () use ($users) {
                return $users->random()->id;
            }
        ]);

        $actions = \App\Models\Action::factory(30)->create([
            'commission_id' => function () use ($commissions) {
                return $commissions->random()->id;
            }
        ]);

        $actions->each(function ($action) use ($employees) { 
            $action->employees()->attach($employees->random(rand(1, 3))->pluck('id')->toArray());
        });

        $messages->each(function ($message) use ($attachments) {
            $randomAttachments = $attachments->random(rand(1, 3))->pluck('id')->toArray();
            $message->attachments()->attach($randomAttachments);
        });

        $actions->each(function ($action) use ($attachments) {
            $action->attachments()->attach($attachments->random(rand(1, 3))->pluck('id')->toArray());
        });

        $commissions->each(function ($commission) use ($attachments) {
            $commission->attachments()->attach($attachments->random(rand(1, 3))->pluck('id')->toArray());
        });
    }
}
