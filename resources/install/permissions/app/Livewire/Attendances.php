<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Student;
use Livewire\Component;
use App\Models\Attendance;

class Attendances extends Component
{
    public $students, $attendanceDate, $date;

    public $attendance = [];

    public function mount()
    {
        $this->students = Student::all();

        $this->attendanceDate = Carbon::now()->format('Y-m-d');
        $this->attendance = Attendance::whereDate('date', $this->attendanceDate)->get()->pluck('status', 'student_id')->toArray();
    }

    public function render()
    {
        $totalAttendance = Attendance::whereDate('date', $this->attendanceDate)->where('status', true)->get();
        return view('livewire.admin.school.attendances.view', compact('totalAttendance'))->extends('components.layouts.admin');
    }

    public function store()
    {
        foreach ($this->attendance as $studentId => $status) {
            Attendance::updateOrCreate([
                'student_id' => $studentId,
                'date' => $this->attendanceDate,
            ], [
                'status' => $status,
            ]);
        }
        $this->dispatch('closeModal');
    }
}
