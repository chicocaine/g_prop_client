<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->longtext('order_details');
            $table->text('delivery_address');
            $table->string('status');
            $table->timestamps();
            $table->dateTime('deadline');
        });

        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained();
            $table->decimal('set_price', 8, 2);
            $table->longtext('commission_details');
            $table->text('delivery_address');
            $table->string('status');
            $table->timestamps();
            $table->dateTime('deadline');
            $table->dateTime('completed_at')->nullable();
        });

        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Commission::class)->constrained();
            $table->string('name');
            $table->longtext('action_details');
            $table->string('status');
            $table->timestamps();
            $table->dateTime('deadline');
            $table->dateTime('completed_at')->nullable();
        });

        Schema::create('threads', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Thread::class, 'thread_id')->constrained();
            $table->foreignIdFor(\App\Models\User::class, 'sender_id')->constrained();
            $table->foreignIdFor(\App\Models\User::class, 'receiver_id')->constrained();
            $table->longtext('message');
            $table->timestamps();
        });

        Schema::create('attachment_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->foreignIdFor(\App\Models\User::class, 'uploaded_by')->constrained();
            $table->string('file_path');
            $table->string('file_size');
            $table->string('file_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('commissions');
        Schema::dropIfExists('actions');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('attachment_files');
    }
};
