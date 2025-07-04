<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('action_location', function (Blueprint $table) {
            $table->id();
            $table->foreignId('action_id')->constrained('chore_actions')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('chore_locations')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['action_id', 'location_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('action_location');
    }
};
