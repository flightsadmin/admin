<?php

namespace App\Livewire\Roster;

use Carbon\Carbon;
use App\Models\Leave;
use App\Models\Roster;
use Livewire\Component;
use App\Models\Employee;
use Livewire\WithPagination;

class Rosters extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    public $staffRosters = [];
    public $selectedDays = [];
    public $rosterFields = [];
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = date('Y-m-d', strtotime('-1 days'));
        $this->endDate = date('Y-m-d', strtotime('+30 days'));
    }

    public function render()
    {
        $employees = Employee::all();
        $rosters = Roster::with('employee')->get()->groupBy('date');
        $dates = $rosters->keys()->all();
        return view('livewire.admin.rosters.view', compact('employees', 'rosters', 'dates'))->extends('components.layouts.admin');
    }
    public function addRosters()
    {
        $this->staffRosters[] = rand(100, 999);
    }

    public function removeRosters($index)
    {
        unset($this->staffRosters[$index]);
        $this->staffRosters = array_values($this->staffRosters);
    }

    public function createRosters()
    {
        foreach ($this->staffRosters as $rostered) {
            foreach ($this->days as $day) {
                $date = Carbon::parse($this->startDate)->next(strtolower($day));

                while ($date->lte($this->endDate)) {
                    $leave = Leave::where('employee_id', $this->rosterFields[$rostered]['employee_id'])
                        ->whereDate('leave_start', '<=', $date)
                        ->whereDate('leave_end', '>=', $date)
                        ->first();

                    $rosterData = [
                        'date' => $date,
                        'employee_id' => $this->rosterFields[$rostered]['employee_id'] ?? null,
                        'shift_start' => isset($this->rosterFields[$rostered]['shift_start']) ? $date->toDateString() . $this->rosterFields[$rostered]['shift_start'] : null,
                        'shift_hours' => $this->rosterFields[$rostered]['shift_hours'] ?? 0,
                    ];

                    if (in_array("$rostered-$day", $this->selectedDays) || $leave) {
                        $rosterData['shift_start'] = null;
                        $rosterData['shift_hours'] = 0;
                    }

                    $rosterData['shift_end'] = $rosterData['shift_start'] ? Carbon::parse($rosterData['shift_start'])->copy()->addHours(intval($rosterData['shift_hours']))->toDateTimeString() : null;

                    Roster::updateOrCreate(
                        ['date' => $date, 'employee_id' => $rosterData['employee_id']],
                        $rosterData
                    );
                    $date = $date->next(strtolower($day));
                }
            }
        }

        $this->dispatch(
            'closeModal',
            icon: 'success',
            message: 'Roster Created Successfully.'
        );
        $this->reset(['selectedDays', 'rosterFields', 'staffRosters']);
    }
}
