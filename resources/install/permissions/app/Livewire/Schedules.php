<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Route;
use App\Models\Flight;
use App\Models\Airline;
use Livewire\Component;
use App\Models\Registration;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Schedules extends Component
{
    use WithFileUploads, WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    public $flightNumbers = [], $selectedDays = [], $flightFields = [], $startDate, $endDate, $file, $selectedFlights = [];

    public function render()
    {
        $airlines = Airline::all();
        $flights = Flight::latest()->paginate();
        return view('livewire.schedules.view', compact('airlines', 'flights'));
    }

    public function mount()
    {
        $this->startDate = Carbon::now()->format('Y-m-d');
        $this->endDate = Carbon::now()->addDays(30)->format('Y-m-d');
    }

    public function addFlights()
    {
        $this->flightNumbers[] = rand(100, 999);
    }

    public function removeFlights($index)
    {
        unset($this->flightNumbers[$index]);
        $this->flightNumbers = array_values($this->flightNumbers);
    }

    public function deleteSelected()
    {
        $deletedFlights = Flight::whereIn('flight_no', $this->selectedFlights)->delete();
        $this->reset(['selectedFlights']);
        session()->flash('message', 'Selected flights deleted successfully.');
    }

    public function createFlights()
    {
        foreach ($this->selectedDays as $selectedDay) {
            list($flightNumber, $day) = explode('-', $selectedDay);

            // Calculate the first occurrence of the selected day within the date range
            $date = Carbon::parse($this->startDate)->next($day);
            if ($date->lt($this->startDate)) {
                $date = $date->next($day);
            }

            // Create flights for each occurrence of the selected day within the date range
            while ($date->lte($this->endDate)) {
                $flight = new Flight;
                $flight->airline_id = strtoupper($this->flightFields[$flightNumber]['airline_id']);
                $flight->flight_no = strtoupper($this->flightFields[$flightNumber]['flight_no']);
                $flight->registration = '';
                $flight->origin = strtoupper($this->flightFields[$flightNumber]['origin'] ?? 'DOH');
                $flight->destination = strtoupper($this->flightFields[$flightNumber]['destination'] ?? 'MCT');
                $flight->scheduled_time_arrival = $date->format('Y-m-d '). $this->flightFields[$flightNumber]['arrival'] ?? '00:00';
                $flight->scheduled_time_departure = $date->format('Y-m-d '). $this->flightFields[$flightNumber]['departure'] ?? '00:00';
                $flight->flight_type = strtoupper($this->flightFields[$flightNumber]['flight_type'] ?? 'departure');
                $flight->save();
                $date = $date->next($day);
            }
        }
        session()->flash('message', 'Schedule Created Successfully.');
        return $this->redirect('/flights', navigate: true);
        $this->reset(['selectedDays', 'flightNumbers', 'flightFields']);
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

            $flight = new Flight;
            $flight->airline_id = $row[0];
            $flight->flight_no = $row[1];
            $flight->registration = $row[2];
            $flight->origin = $row[3];
            $flight->destination = $row[4];
            $flight->scheduled_time_arrival = date('Y-m-d H:i', strtotime($row[5]));
            $flight->scheduled_time_departure = date('Y-m-d H:i', strtotime($row[6]));
            $flight->flight_type = $row[7];
            $flight->save();
        }

        session()->flash('message', 'Schedule Imported Successfully.');
        return $this->redirect('/flights', navigate: true);
    }

    public function downloadSample()
    {
        $filename = 'flights.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];
    
        $callback = function () {
            $file = fopen('php://output', 'w');
    
            $headers = [
                'airline_id',
                'flight_no',
                'registration',
                'origin',
                'destination',
                'scheduled_time_arrival',
                'scheduled_time_departure',
                'flight_type',
            ];
    
            fputcsv($file, $headers);
            
            $start_date = Carbon::now('Asia/Qatar');
            $end_date = $start_date->copy()->addDays(30);
            $airlines = Airline::all();
            
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
    
                        fputcsv($file, [
                            $airlineId,
                            $flightNo,
                            $registration,
                            $origin,
                            $destination,
                            $arrivalTime,
                            $departureTime,
                            $flightType,
                        ]);
                    }
                }
                $start_date->addDay();
            }
    
            fclose($file);
        };
    
        return new StreamedResponse($callback, 200, $headers);
        session()->flash('message', 'Sample File Downloaded Successfully.');
    }
}