<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        //  Update existing users with old default
        DB::table('users')
            ->where('profile_picture', 'storage/default-avatar.png')
            ->update([
                'profile_picture' => 'images/default-avatar.png'
            ]);


        Schema::table('users', function (Blueprint $table) {
            $table
                ->string('profile_picture')
                ->default('images/default-avatar.png')
                ->change();
        });
    }

    public function down(): void
    {
        // Revert default if needed
        Schema::table('users', function (Blueprint $table) {
            $table
                ->string('profile_picture')
                ->default('storage/default-avatar.png')
                ->change();
        });

        DB::table('users')
            ->where('profile_picture', 'images/default-avatar.png')
            ->update([
                'profile_picture' => 'storage/default-avatar.png'
            ]);
    }
};
