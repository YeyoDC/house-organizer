<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHouseholdIdToGroceryItemsTable extends Migration
{
    public function up(): void
    {
        Schema::table('grocery_items', function (Blueprint $table) {
            // Make created_by nullable if not done yet
            $table->foreignId('created_by')->nullable()->change();

            // Add household_id column
            $table->foreignId('household_id')->nullable()->constrained('households')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('grocery_items', function (Blueprint $table) {
            $table->dropForeign(['household_id']);
            $table->dropColumn('household_id');

            // Revert created_by to not nullable (optional)
            $table->foreignId('created_by')->nullable(false)->change();
        });
    }
}
