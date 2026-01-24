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
        Schema::create('ticket_step_logs', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('ticket_step_id')->constrained('ticket_steps')->cascadeOnDelete();
            $table->enum('event', [
                'created',
                'called',
                'started',
                'ended',
                'skipped',
                'cancelled'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_step_logs');
    }
};
