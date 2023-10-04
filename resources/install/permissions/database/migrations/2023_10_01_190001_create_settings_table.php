<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->nullable()->default(null);
            $table->string('site_email')->nullable()->default(null);
            $table->string('site_title')->nullable()->default(null);
            $table->string('site_short_code')->nullable()->default(null);
            $table->string('site_theme')->nullable()->default(null);
            $table->string('site_description')->nullable()->default(null);
            $table->string('footer_text')->nullable()->default(null);
            $table->timestamps();
        });

        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('receiver_id');
            $table->foreign('sender_id')->references('id')->on('users');
            $table->foreign('receiver_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->text('body');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversations');
    }
};