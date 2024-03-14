<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('airlines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('iata_code');
            $table->string('base');
            $table->string('base_iata_code');
            $table->timestamps();
        });

        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('flight_no');
            $table->string('registration');
            $table->string('origin');
            $table->string('destination');
            $table->timestamp('scheduled_time_arrival');
            $table->timestamp('scheduled_time_departure');
            $table->enum('flight_type', ['arrival', 'departure']);
            $table->foreignId('airline_id')->constrained('airlines')->onDelete('cascade');
            $table->timestamps();
        });
        
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration')->unique();
            $table->string('aircraft_type');
            $table->foreignId('airline_id')->constrained('airlines')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('service_lists', function (Blueprint $table) {
            $table->id();
            $table->string('service');
            $table->string('price');
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('service_lists')->onDelete('cascade');
            $table->foreignId('flight_id')->constrained('flights')->onDelete('cascade');
            $table->timestamp('start');
            $table->timestamp('finish');
            $table->timestamps();
        });

        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_id')->constrained('flights')->onDelete('cascade');
            $table->timestamp('offblocks')->nullable();
            $table->timestamp('airborne')->nullable();
            $table->timestamp('touchdown')->nullable();
            $table->timestamp('onblocks')->nullable();
            $table->integer('passengers')->nullable();
            $table->time('flight_time')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('origin');
            $table->string('destination');
            $table->time('flight_time')->nullable();
            $table->foreignId('airline_id')->constrained('airlines')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->foreignId('airline_id')->constrained('airlines')->onDelete('cascade');
            $table->foreignId('route_id')->constrained('routes')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('airline_delay_codes', function (Blueprint $table) {
            $table->id();
            $table->string('numeric_code');
            $table->string('alpha_numeric_code')->nullable();
            $table->string('description');
            $table->string('accountable')->nullable();
            $table->foreignId('airline_id')->constrained('airlines')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('flight_delays', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('duration');
            $table->string('description')->nullable();
            $table->foreignId('flight_id')->constrained('flights')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('flight_delays');
        Schema::dropIfExists('airline_delay_codes');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('routes');
        Schema::dropIfExists('movements');
        Schema::dropIfExists('services');
        Schema::dropIfExists('service_lists');
        Schema::dropIfExists('registrations');
        Schema::dropIfExists('flights');
        Schema::dropIfExists('airlines');
    }
};
