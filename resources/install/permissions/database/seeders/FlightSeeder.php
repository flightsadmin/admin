<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\{User, Route, Flight, Airline, ServiceList, Registration, AirlineDelayCode};

class FlightSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        //Seed Airlines
        $airlines = [
            [ "name" => "Flydubai",         "iata_code" => "FZ",  "base_iata_code" => "DXB", "base" => "Dubai, United Arab Emirates"],
            [ "name" => "Air Arabia",       "iata_code" => "G9",  "base_iata_code" => "SHJ", "base" => "Sharjah, United Arab Emirates"],
            [ "name" => "Oman Air",         "iata_code" => "WY",  "base_iata_code" => "MCT", "base" => "Muscat, Oman"],
            [ "name" => "Salamair",         "iata_code" => "OV",  "base_iata_code" => "MCT", "base" => "Muscat, Oman"],
            [ "name" => "Qatar Airways",    "iata_code" => "QR",  "base_iata_code" => "DOH", "base" => "Doha, Qatar"],
            [ "name" => "Kenya Airways",    "iata_code" => "KQ",  "base_iata_code" => "NBO", "base" => "Nairobi, Kenya"],
            [ "name" => "Emirates",         "iata_code" => "EK",  "base_iata_code" => "DXB", "base" => "Dubai, United Arab Emirates"],
            [ "name" => "Air India",        "iata_code" => "AI",  "base_iata_code" => "BOM", "base" => "Bombay, India"],
            [ "name" => "Indigo  Airlines", "iata_code" => "6E",  "base_iata_code" => "HYD", "base" => "Hyderabad, India"],
            [ "name" => "Jambojet",         "iata_code" => "JM",  "base_iata_code" => "NBO", "base" => "Nairobi, Kenya"],
        ];

        foreach ($airlines as $airline) {
            Airline::updateOrCreate($airline);
        }

        // Seed Services
        $services = [
            [ 'service' => 'PAX Bus',   'price' => 120],
            [ 'service' => 'Crew Bus',  'price' => 100],
            [ 'service' => 'Pushback',  'price' => 200],
            [ 'service' => 'Towing',    'price' => 220],
            [ 'service' => 'Cleaning',  'price' => 150],
            [ 'service' => 'Lavatory',  'price' => 170],
            [ 'service' => 'Check-in',  'price' => 300],
            [ 'service' => 'Photocopy', 'price' => 20],
            [ 'service' => 'Printing',  'price' => 20],
        ];

        foreach ($services as $service ) {
           ServiceList::updateOrCreate($service);
        }

        // Seed Routes and Email Addresses
        $airlines = Airline::all();
        $airports = ['DOH', 'JFK', 'LHR', 'NBO', 'MCT', 'KWI', 'SYD', 'JED', 'DXB', 'SIN'];
        $departureAirport = $airports[array_rand($airports)];
        foreach ($airlines as $airline) {
            for ($i=0; $i < 2; $i++) { 

                $origin = $departureAirport;
                $destination = $airports[array_rand($airports)];
                
                while ($origin === $destination) {
                    $destination = $airports[array_rand($airports)];
                }
            
                $route = Route::updateOrCreate([
                    'airline_id' => $airline->id,
                    'origin' => $origin,
                    'destination' => $destination,
                    'flight_time'=>date('H:i', strtotime('+'. rand(2, 3) .' hours')),
                ]);
            
                $route->emails()->updateOrCreate([
                    'email' => 'flightsapps@gmail.com',
                    'airline_id' => $airline->id,
                ]);
            
                $departureAirport = $destination;
            }
        }
        
        // Seed Registrations
        $aircraft_types = ['Airbus A320', 'Airbus A330', 'Airbus A350', 'Airbus A380', 'Boeing 737', 'Boeing 777', 'Boeing 747', 'Boeing 787'];
        $used_registrations = Registration::all()->pluck('registration')->toArray();
        for ($i = 0; $i < 50; $i++) {
            $registration = '';
            do {
                $registration = 'A7B' . chr(rand(65, 90)) . chr(rand(65, 90));
            } while (in_array($registration, $used_registrations));
            $used_registrations[] = $registration;

            $aircraftType = $aircraft_types[array_rand($aircraft_types)];
            $airlineId = rand(1, $airlines->count());

            Registration::updateOrCreate([
                'registration'  => $registration,
                'aircraft_type' => $aircraftType,
                'airline_id'    => $airlineId,
            ]);
        }

        // Seed Flights
        $start_date = Carbon::now('Asia/Qatar');
        $end_date = $start_date->copy()->addDays(30);

        while ($start_date <= $end_date) {
            foreach ($airlines as $key => $value) {
                foreach (Route::latest()->where('airline_id', $value->id)->get() as $sector) {
                    $airlineId = $value->id;
                    $flightNo = $value->iata_code . str_pad(rand(1, 999), 4, '0', STR_PAD_LEFT);
                    $registration =  Registration::where('airline_id', $airlineId)->pluck('registration')->first();
                    $origin = $sector->origin;
                    $destination = $sector->destination;
                    $arrivalTime = $start_date->copy()->addMinutes(rand(0, 1440))->format('Y-m-d H:i:s');
                    $departureTime = date('Y-m-d H:i:s', strtotime($arrivalTime . ' + ' . rand(60, 180) . ' minutes'));
                    $flightType = ($key % 2 == 0) ? 'departure' : 'arrival';

                    Flight::updateOrCreate([
                        'airline_id'                => $airlineId,
                        'flight_no'                 => $flightNo,
                        'registration'              => $registration,
                        'origin'                    => $origin,
                        'destination'               => $destination,
                        'scheduled_time_arrival'    => $arrivalTime,
                        'scheduled_time_departure'  => $departureTime,
                        'flight_type'               => $flightType,
                    ]);
                }
            }
            $start_date->addDay();
        }

        // Seed Delay Codes
        $responsible = ['Ground Handling', 'Airport', 'Airline', 'Police', 'Immigration'];
        foreach ($airlines as $key => $value) {
            for ($i = 0; $i < 99; $i++) {
                $numericCode      = str_pad($i+1, 2, '0', STR_PAD_LEFT);
                $alphaNumericCode = $numericCode. chr(rand(65, 90));
                $description      = strtoupper(preg_replace('/[^A-Za-z0-9 ]/', '', $faker->realText(50)));
                $accountable      = $responsible[array_rand($responsible)];
                $airlineId        = $value->id;
            
                AirlineDelayCode::updateOrCreate([
                    'numeric_code'          => $numericCode,
                    'alpha_numeric_code'    => $alphaNumericCode,
                    'description'           => $description,
                    'accountable'           => $accountable,
                    'airline_id'            => $airlineId,
                ]);
            }            
        }
    }
}