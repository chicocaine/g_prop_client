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
            $table->unsignedBigInteger('user_id');
            $table->longtext('order_details');
            $table->string('status');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('set_price', 8, 2);
            $table->longtext('commission_details');
            $table->string('status');
            $table->timestamps();
            $table->dateTime('deadline');
            $table->dateTime('completed_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commission_id');
            $table->string('name');
            $table->longtext('action_details');
            $table->string('status');
            $table->timestamps();
            $table->dateTime('deadline');
            $table->dateTime('completed_at')->nullable();

            $table->foreign('commission_id')->references('id')->on('commissions');
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->longtext('message');
            $table->timestamps();
 
            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('receiver_id')->references('id')->on('users');
        });

        Schema::create('attachment_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('file_path');
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
