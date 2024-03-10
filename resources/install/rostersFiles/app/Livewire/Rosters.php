<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Roster;
use Livewire\WithPagination;

class Rosters extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    public $staffRosters = [], $selectedDays = [], $scheduleFields = [], $startDate, $endDate;

    public function mount()
    {
        $this->startDate = date('Y-m-d', strtotime('-1 days'));
        $this->endDate = date('Y-m-d', strtotime('+30 days'));
    }

    public function render()
    {
        $users = User::all();
        $roster = Roster::fetchRoster();
        return view('livewire.admin.schedules.view', compact('users', 'roster'))->extends('components.layouts.admin');
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
        foreach ($this->staffRosters as $index => $schedule) {
            foreach ($this->days as $day) {
                if (!in_array("$schedule-$day", $this->selectedDays)) {
                    $date = Carbon::parse($this->startDate)->next(strtolower($day));

                    while ($date->lte($this->endDate)) {
                        $scheduleData = [
                            'date' => $date,
                            'user_id' => $this->scheduleFields[$schedule]['user_id'],
                            'shift_start' => $date->format('Y-m-d ') . $this->scheduleFields[$schedule]['shift_start'],
                            'shift_hours' => $this->scheduleFields[$schedule]['shift_hours'],
                        ];
                        $scheduleData['shift_end'] = Carbon::parse($scheduleData['shift_start'])->copy()->addHours($scheduleData['shift_hours'])->toDateTimeString();

                        Roster::updateOrCreate(
                            ['date' => $date, 'user_id' => $scheduleData['user_id']],
                            $scheduleData
                        );
                        $date = $date->next(strtolower($day));
                    }
                } else {
                    $date = Carbon::parse($this->startDate)->next(strtolower($day));

                    while ($date->lte($this->endDate)) {
                        $scheduleData = [
                            'date' => $date,
                            'user_id' => $this->scheduleFields[$schedule]['user_id'],
                            'shift_start' => null,
                            'shift_hours' => 0,
                        ];
                        $scheduleData['shift_end'] = null;

                        Roster::updateOrCreate(
                            ['date' => $date, 'user_id' => $scheduleData['user_id']],
                            $scheduleData
                        );
                        $date = $date->next(strtolower($day));
                    }
                }
            }
        }

        $this->dispatch(
            'closeModal',
            icon: 'success',
            message: 'Roster Created Successfully.',
        );
        $this->reset(['selectedDays', 'scheduleFields']);
        return $this->redirect(route('admin'), true);
    }
}