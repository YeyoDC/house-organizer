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
            $table->float('unit_price')->default(0)->change();
            $table->float('total_price')->default(0)->change();
        });
        Schema::table('grocery_stocks', function (Blueprint $table) {
            $table->float('unit_price')->default(0)->change();
            $table->float('total_price')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grocery_list_items', function (Blueprint $table) {
            $table->float('unit_price')->default(null)->change();
            $table->float('total_price')->default(null)->change();
        });

        Schema::table('grocery_stocks', function (Blueprint $table) {
            $table->float('unit_price')->default(null)->change();
            $table->float('total_price')->default(null)->change();
        });
    }
};
