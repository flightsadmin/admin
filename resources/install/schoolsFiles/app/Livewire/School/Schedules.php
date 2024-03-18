<?php

namespace App\Livewire\School;

use App\Models\Grade;
use App\Models\Subject;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Timetable;
use Livewire\WithPagination;

class Schedules extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    public $flightNumbers = [], $selectedDays = [], $flightFields = [], $startDate, $endDate, $selectedFlights = [];

    public function render()
    {
        $timetables = Timetable::latest()->paginate();
        $classes = Grade::all();
        $subjects = Subject::all();
        return view(
            'livewire.school.schedules.view',
            compact('classes', 'subjects', 'timetables')
        )->extends('components.layouts.admin');
    }

    public function mount()
    {
        $this->startDate = now()->format('Y-m-d');
        $this->endDate = now()->addDays(30)->format('Y-m-d');
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

    public function edit($id)
    {
        $timetable = Timetable::findOrFail($id);
        $this->flightNumbers[] = [rand(100, 999)];
        $this->flightFields[] = [
            'start' => $timetable->start_time,
            'end' => $timetable->end_time,
        ];
    }

    public function deleteSelected()
    {
        Timetable::whereIn('id', $this->selectedFlights)->delete();
        $this->reset(['selectedFlights']);
        session()->flash('message', 'Selected flights deleted successfully.');
    }

    public function createFlights()
    {
        foreach ($this->selectedDays as $selectedDay) {
            list($flightNumber, $day) = explode('-', $selectedDay);

            $date = Carbon::parse($this->startDate)->next($day);
            if ($date->lt($this->startDate)) {
                $date = $date->next($day);
            }

            while ($date->lte($this->endDate)) {
                $flight = new Timetable;
                $flight->grade_id = $this->flightFields[$flightNumber]['grade_id'];
                $flight->name = ucwords($this->flightFields[$flightNumber]['subject']);
                $flight->start_time = $date->format('Y-m-d ') . $this->flightFields[$flightNumber]['start'] ?? '00:00';
                $flight->end_time = $date->format('Y-m-d ') . $this->flightFields[$flightNumber]['end'] ?? '00:00';
                $flight->save();
                $date = $date->next($day);
            }
        }
        session()->flash('message', 'Schedule Created Successfully.');
        $this->reset(['selectedDays', 'flightNumbers', 'flightFields']);
    }
}