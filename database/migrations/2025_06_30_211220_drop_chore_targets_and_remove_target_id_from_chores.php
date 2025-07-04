<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropChoreTargetsAndRemoveTargetIdFromChores extends Migration
{
    public function up()
    {
        // First remove foreign key and column from chores table
        Schema::table('chores', function (Blueprint $table) {
            if (Schema::hasColumn('chores', 'target_id')) {
                $table->dropForeign(['target_id']);
                $table->dropColumn('target_id');
            }
        });

        // Then drop the chore_targets table
        Schema::dropIfExists('chore_targets');
    }


    public function down()
    {
        // Recreate the chore_targets table (adjust columns as needed)
        Schema::create('chore_targets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Add back target_id column to chores table
        Schema::table('chores', function (Blueprint $table) {
            $table->unsignedBigInteger('target_id')->nullable()->after('location_id');

            // Add foreign key constraint again (adjust table/column names if different)
            $table->foreign('target_id')->references('id')->on('chore_targets')->onDelete('set null');
        });
    }
}
