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
        Schema::create('employee_action', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('action_id');
            $table->timestamp('created_at');

            $table->primary(['employee_id', 'action_id']);

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');
        });

        Schema::create('order_attachment', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('attachment_id');
            $table->timestamp('created_at');

            $table->primary(['order_id', 'attachment_id']);

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('attachment_id')->references('id')->on('attachment_files')->onDelete('cascade');
        });

        Schema::create('commission_attachment', function (Blueprint $table) {
            $table->unsignedBigInteger('commission_id');
            $table->unsignedBigInteger('attachment_id');
            $table->timestamp('created_at');

            $table->primary(['commission_id', 'attachment_id']);

            $table->foreign('commission_id')->references('id')->on('commissions')->onDelete('cascade');
            $table->foreign('attachment_id')->references('id')->on('attachment_files')->onDelete('cascade');
        });

        Schema::create('message_attachment', function (Blueprint $table) {
            $table->unsignedBigInteger('message_id');
            $table->unsignedBigInteger('attachment_id');
            $table->timestamp('created_at');

            $table->primary(['message_id', 'attachment_id']);

            $table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');
            $table->foreign('attachment_id')->references('id')->on('attachment_files')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_action');
        Schema::dropIfExists('order_attachment');
        Schema::dropIfExists('commission_attachment');
        Schema::dropIfExists('message_attachment');
    }
};
