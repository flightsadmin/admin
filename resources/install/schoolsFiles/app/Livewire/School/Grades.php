<?php

namespace App\Livewire\School;

use Carbon\Carbon;
use App\Models\Grade;
use Livewire\Component;
use App\Models\Timetable;
use Livewire\WithPagination;

class Grades extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $grade_id, $name, $description, $keyWord;
    public $timetable;

    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        $grades = Grade::with('students')
            ->orWhere('name', 'LIKE', $keyWord)
            ->paginate();
        return view('livewire.admin.school.grades.view', [
            'grades' => $grades
        ])->extends('components.layouts.admin');
    }

    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'description' => 'required|min:10'
        ]);

        Grade::updateOrCreate(['id' => $this->grade_id], $validatedData);

        $this->alert();
        $this->reset();
    }

    public function edit($id)
    {
        $grade = Grade::findOrFail($id);
        $this->grade_id = $id;
        $this->name = $grade->name;
        $this->description = $grade->description;
    }

    public function details($id)
    {
        $grade = Grade::findOrFail($id);

        $firstDay = now()->firstOfMonth();
        $lastDay = now()->lastOfMonth();

        $days = collect();

        for ($day = $firstDay; $day->lte($lastDay); $day->addDay()) {
            $dayInfo = [
                'day' => $day->format('D'),
                'date' => $day->format('d'),
                'timetable' => Timetable::where('grade_id', $id)
                    ->where('start_time', ">=", $day->startOfDay()->format('Y-m-d H:i:s'))
                    ->where('end_time', "<=", $day->endOfDay()->format('Y-m-d H:i:s'))
                    ->pluck('name')->toArray(),
            ];
            $days->push($dayInfo);
        }

        return view('livewire.admin.school.grades.details', [
            'grade' => $grade,
            'days' => $days,
        ]);
    }

    public function alert()
    {
        $this->dispatch(
            'closeModal',
            icon: "success",
            message: $this->grade_id ? 'Class Updated Successfully.' : 'Class Created Successfully.',
        );
    }

    public function destroy($id)
    {
        Grade::findOrFail($id)->delete();
        session()->flash('message', 'Grade Deleted Successfully.');
    }
}