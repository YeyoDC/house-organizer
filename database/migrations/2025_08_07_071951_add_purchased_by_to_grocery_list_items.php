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
        Schema::table('grocery_list_items', function (Blueprint $table) {
            $table->foreignId('purchased_by')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grocery_list_items', function (Blueprint $table) {
            $table->dropForeign('grocery_list_items_purchased_by_foreign');
        });
    }
};
