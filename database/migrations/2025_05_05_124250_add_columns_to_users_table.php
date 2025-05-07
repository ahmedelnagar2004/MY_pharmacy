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
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('avatar')->nullable();
            $table->string('social_token')->nullable();
            $table->string('social_refresh_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'google_id',
                'facebook_id',
                'avatar',
                'social_token',
                'social_refresh_token'
            ]);
        });
    }
};