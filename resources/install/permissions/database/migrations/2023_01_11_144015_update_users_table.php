<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->after('name', function ($table) {
                $table->string('email', 100)->nullable()->change();
                $table->string('phone')->nullable();
                $table->string('username')->unique()->nullable();
                $table->string('title')->nullable();
                $table->string('photo')->default('users/noimage.jpg');
                $table->string('auth_type')->default('email');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'username', 'title', 'photo', 'auth_type']);
        });
    }
};