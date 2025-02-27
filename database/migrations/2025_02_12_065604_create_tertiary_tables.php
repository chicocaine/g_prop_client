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
            $table->foreignIdFor(\App\Models\Employee::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Action::class)->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->primary(['employee_id', 'action_id']);
        });

        Schema::create('commission_attachment', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Commission::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Attachment::class)->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->primary(['commission_id', 'attachment_id']);
        });

        Schema::create('message_attachment', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Message::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Attachment::class)->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->primary(['message_id', 'attachment_id']);
        });

        Schema::create('action_attachment', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Action::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Attachment::class)->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->primary(['action_id', 'attachment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_action');
        Schema::dropIfExists('commission_attachment');
        Schema::dropIfExists('message_attachment');
        Schema::dropIfExists('action_attachment');
    }
};
