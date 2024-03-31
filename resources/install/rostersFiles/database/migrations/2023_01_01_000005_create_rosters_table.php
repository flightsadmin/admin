<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('role')->nullable();
            $table->string('department')->nullable();
            $table->timestamps();
        });

        Schema::create('rosters', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->timestamp('shift_start')->nullable();
            $table->timestamp('shift_end')->nullable();
            $table->smallInteger('shift_hours')->nullable();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->timestamps();
        });
        
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->date('leave_start');
            $table->date('leave_end');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->timestamps();
        });
        
        Schema::create('staff_off_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('off_day');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
        Schema::dropIfExists('rosters');
        Schema::dropIfExists('leaves');
        Schema::dropIfExists('staff_off_days');
    }
};