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
        $threads = \App\Models\Thread::factory(5)->create();

        $orders = \App\Models\Order::factory(30)->create([
            'user_id' => function () use ($users) {
                return $users->random()->id;
            }
        ]);

        $commissions = \App\Models\Commission::factory(30)->create([
            'user_id' => function () use ($users) {
                return $users->random()->id;
            }
        ]);

        $messages = \App\Models\Message::factory(30)->create([
            'thread_id' => function () use ($threads) {
                return $threads->random()->id;
            },
            'sender_id' => function () use ($users) {
                return $users->random()->id;
            },
            'receiver_id' => function () use ($users) {
                return $users->random()->id;
            }
        ]);

        $actions = \App\Models\Action::factory(30)->create([
            'commission_id' => function () use ($commissions) {
                return $commissions->random()->id;
            }
        ]);

        $actions->each(function ($action) use ($employees) {
            $action->employees()->attach(
                collect($employees->random(rand(1, 5)))->pluck('id')->toArray()
            );
        });

        $messages->each(function ($message) use ($attachments) {
            $message->attachments()->attach(
                collect($attachments->random(rand(1, 5)))->pluck('id')->toArray()
            );
        });

        $orders->each(function ($order) use ($attachments) {
            $order->attachments()->attach(
                collect($attachments->random(rand(1, 5)))->pluck('id')->toArray()
            );
        });

        $actions->each(function ($action) use ($attachments) {
            $action->attachments()->attach(
                collect($attachments->random(rand(1, 5)))->pluck('id')->toArray()
            );
        });

        $commissions->each(function ($commissions) use ($attachments) {
            $commissions->attachments()->attach(
                collect($attachments->random(rand(1, 5)))->pluck('id')->toArray()
            );
        });
    }
}
