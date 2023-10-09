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
        
        Schema::create('student_parents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->timestamps();
        });

        Schema::create('class_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('student_parent_id')->constrained('student_parents')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('class_models')->onDelete('cascade');
            $table->string('roll_number');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->date('date_of_birth');
            $table->string('address');
            $table->timestamps();
        });

        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
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