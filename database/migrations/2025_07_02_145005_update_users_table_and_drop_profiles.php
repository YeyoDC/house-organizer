<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {

        Schema::dropIfExists('profiles');

        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('email');
            $table->string('profile_picture')->default('storage/default-avatar.png')->after('username');
        });


    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([ 'username', 'profile_picture']);
        });

        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('profile_picture')->nullable();
            $table->timestamps();
        });
    }
};

