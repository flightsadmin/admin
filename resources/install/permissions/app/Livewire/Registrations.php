<?php

namespace App\Livewire;

use App\Models\Airline;
use Livewire\Component;
use App\Models\Registration;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Registrations extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $registration, $aircraft_type, $airline_id, $registration_id, $keyWord, $file;

    
    public function render()
    {
        $keyWord = '%'. $this->keyWord .'%';
        $registrations = Registration::with('airline')
        ->orWhere('registration', 'LIKE', $keyWord)
        ->paginate();
        return view('livewire.registrations.view', compact('registrations'));
    }

    public function cancel()
    {
        $this->reset();
    }

    public function store()
    {
        $this->validate([
            'registration'  => 'required',
            'aircraft_type' => 'required',
            'airline_id'    => 'required',
        ]);
        Registration::updateOrCreate(['id' => $this->registration_id], [
            'registration' => strtoupper(str_replace('-','', $this->registration)),
            'aircraft_type' => $this->aircraft_type,
            'airline_id' => $this->airline_id,
        ]);

        $this->reset();
        $this->dispatch('closeModal');
        session()->flash('message', $this->registration_id ? 'Registration Updated Successfully.' : 'Registration Created Successfully.');
    }

    public function edit($id)
    {
        $record = Registration::findOrFail($id);
        $this->registration_id = $id;
        $this->registration = $record->registration;
        $this->aircraft_type = $record->aircraft_type;
        $this->airline_id = $record->airline_id;
    }

    public function destroy($id)
    {
        Registration::findOrFail($id)->delete();
        session()->flash('message', 'Registration Deleted Successfully.');
    }

    public function registrationSample()
    {
        $filename = 'registrations.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];
    
        $aircraft_types = ['Airbus A320', 'Airbus A330', 'Airbus A350', 'Airbus A380', 'Boeing 737', 'Boeing 777', 'Boeing 747', 'Boeing 787'];
        
        $callback = function () use ($aircraft_types) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['registration', 'aircraft_type', 'airline_id']);
            
            $airlines = Airline::all();
            $used_registrations = Registration::all()->pluck('registration')->toArray();
            for ($i = 0; $i < 50; $i++) {
                $registration = '';
                do {
                    $registration = 'A7B' . chr(rand(65, 90)) . chr(rand(65, 90));
                } while (in_array($registration, $used_registrations));
                $used_registrations[] = $registration;
    
                $aircraftType = $aircraft_types[array_rand($aircraft_types)];
                $airlineId = rand(1, $airlines->count());

                fputcsv($file, [$registration, $aircraftType, $airlineId]);
            }    
            fclose($file);
        };
    
        return new StreamedResponse($callback, 200, $headers);
    }

    public function importRegistration()
    {
        // Validate the file upload
        $this->validate([
            'file' => 'nullable|mimes:csv,txt'
        ]);
    
        // Read the CSV file using the `fgetcsv()` function
        $csvFile = fopen($this->file->getRealPath(), 'r');
        $headerRow = true;
        $importedRegistrations = [];
    
        while (($row = fgetcsv($csvFile)) !== false) {
            // Skip the header row
            if ($headerRow) {
                $headerRow = false;
                continue;
            }
    
            $registrationNumber = $row[0];
            if (in_array($registrationNumber, $importedRegistrations)) {
                continue; // Skip the row if registration number already imported
            }
    
            $registration = new Registration;
            $registration->registration = $registrationNumber;
            $registration->aircraft_type = $row[1];
            $registration->airline_id = $row[2];
            $registration->save();
    
            // Add the registration number to the list of imported registrations
            $importedRegistrations[] = $registrationNumber;
        }
    
        session()->flash('message', 'Airlines Imported Successfully.');
        return $this->redirect('/registrations', navigate: true);
    }
}