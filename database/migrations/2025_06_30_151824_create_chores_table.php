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
        Schema::create('chores', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('action_id')->constrained('chore_actions');
            $table->foreignId('location_id')->constrained('chore_locations');
            $table->foreignId('target_id')->constrained('chore_targets');
            $table->string('title')->nullable();
            $table->foreignId('household_id')->nullable()->constrained('households')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->text('notes')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('recurrence', ['none', 'daily', 'weekly','bi-weekly', 'monthly'])->default('none');
            $table->date('last_generated_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chores');
    }
};
