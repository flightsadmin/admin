<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Route;
use App\Models\Address;
use App\Models\Airline;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Airlines extends Component
{ 
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $name, $iata_code, $base, $base_iata_code, $airline_id, $keyWord, $file;
    public $origin, $destination, $flight_time, $emails = [], $email;

    public function render()
    {
        $keyWord = '%'. $this->keyWord .'%';
        $airlines = Airline::latest()
                    ->orWhere('name', 'LIKE', $keyWord)
                    ->orWhere('iata_code', 'LIKE', $keyWord)
                    ->paginate();
        return view('livewire.airlines.view', [
            'airlines' => $airlines
        ]);
    }
    
    public function saveAirline()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'iata_code' => 'required|max:2|unique:airlines,id,'. $this->airline_id,
            'base' => 'required',
            'base_iata_code' => 'required',
        ]);

        Airline::updateOrCreate(['id' => $this->airline_id], $validatedData);

        $this->dispatch('closeModal');
        session()->flash('message', 'Airline created successfully.');
        $this->reset();
    }

    public function edit($id)
    {
        $airline = Airline::findOrFail($id);
        $this->airline_id = $id;
        $this->name = $airline->name;
        $this->iata_code = $airline->iata_code;
        $this->base = $airline->base;
        $this->base_iata_code = $airline->base_iata_code;
    }

    public function destroy($id)
    {
        Airline::findOrFail($id)->delete();
        session()->flash('message', 'Airline Deleted Successfully.');
    }

    public function addEmail($email)
    {
        $this->validate(['email' => 'required|email']);
        $this->emails[] = strtolower($email);
    }

    public function removeEmail($email)
    {
        $key = array_search($email, $this->emails);

        if ($key !== false) {
            unset($this->emails[$key]);
        }
    }

    public function saveRoute()
    {
        $validatedData = $this->validate([
                'airline_id'    => 'required|exists:airlines,id',
                'origin'        => 'required|string|min:3|max:20',
                'destination'   => 'required|string|min:3|max:20',
            ]);
        $route = Route::updateOrCreate($validatedData);
        $route->flight_time = date("H:i", strtotime(str_pad(trim($this->flight_time), 4, '0', STR_PAD_LEFT))); 
        $route->save();

        $defaultAddress = ['george@flightadmin.info', 'flightsapps@gmail.com'];
        $addresses = array_merge($this->emails, $defaultAddress);
        foreach ($addresses as $email) {
            $route->emails()->updateOrCreate([
                'email' => strtolower($email),
                'airline_id' => $validatedData['airline_id'],
            ]);
        }
        $this->dispatch('closeModal');
        session()->flash('message', $route->wasRecentlyCreated ? 'Route Created successfully.' : 'Route Updated successfully.');
        $this->reset();
    }

    public function editRoute($id)
    {
        $route = Route::findOrFail($id);
        $this->airline_id = $route->airline_id;
        $this->origin = $route->origin;
        $this->destination = $route->destination;
        $this->flight_time = $route->flight_time;
        $this->emails = $route->emails()->pluck('email')->toArray();
    }

    public function deleteRoute($id)
    {
        Address::findOrFail($id)->delete();
        session()->flash('message', 'Route Deleted Successfully.');
    }

    public function downloadAirlines()
    {
        $filename = 'airlines.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];
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

        $callback = function () use ($airlines) {
            $file = fopen('php://output', 'w');
    
            fputcsv($file, ['name', 'iata_code', 'base', 'base_iata_code']);
    
            foreach ($airlines as $key => $value) {
                    $name = $value['name'];
                    $iataCode = $value['iata_code'];
                    $base = $value['base'];
                    $baseIataCode = $value['base_iata_code'];
        
                    fputcsv($file, [$name, $iataCode, $base, $baseIataCode]);
            }
    
            fclose($file);
        };
    
        return new StreamedResponse($callback, 200, $headers);
    }

    public function import()
    {
        // Validate the file upload
        $this->validate([
            'file' => 'nullable|mimes:csv,txt'
        ]);

        // Read the CSV file using the `fgetcsv()` function
        $csvFile = fopen($this->file->getRealPath(), 'r');
        $headerRow = true;
        while (($row = fgetcsv($csvFile)) !== false) {
            // Skip the header row
            if ($headerRow) {
                $headerRow = false;
                continue;
            }

            $airline = new Airline;
            $airline->name = $row[0];
            $airline->iata_code = $row[1];
            $airline->base = $row[2];
            $airline->save();
        }

        session()->flash('message', 'Airlines Imported Successfully.');
        return $this->redirect('/airlines', navigate: true);
    }
}