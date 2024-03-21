<?php

namespace App\Livewire\School;

use Carbon\Carbon;
use App\Models\Timetable;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Timetables extends Component
{
    public function newTimetable($name, $startDate, $endDate)
    {
        $validated = Validator::make(
            [
                'name' => $name,
                'start_time' => Carbon::parse($startDate),
                'end_time' => Carbon::parse($endDate),
                'grade_id'=> 1,
            ],
            [
                'name' => 'required|min:1|max:40',
                'start_time' => 'required',
                'end_time' => 'required',
                'grade_id'=> 'nullable',
            ]
        )->validate();

        $timetable = Timetable::create(
            $validated
        );

        return $timetable->id;
    }

    public function updateTimetable($id, $name, $startDate, $endDate)
    {
        $validated = Validator::make(
            [
                'name'=> $name,
                'start_time' => Carbon::parse($startDate),
                'end_time' => Carbon::parse($endDate),
                'grade_id'=> 1,
            ],
            [
                'name'=> 'required',
                'start_time' => 'required',
                'end_time' => 'required',
                'grade_id'=> 'nullable',
            ]
        )->validate();

        Timetable::findOrFail($id)->update($validated);
        $this->dispatch(
            'closeModal',
            icon: 'success',
            message: 'Timetable Updated Successfully',
        );
    }

    public function render()
    {
        $timetables = [];

        foreach (Timetable::all() as $timetable) {
            $timetables[] =  [
                'id' => $timetable->id,
                'title' => $timetable->name,
                'start' => $timetable->start_time,
                'end' => $timetable->end_time,
                'class'=> $timetable->grade_id,
            ];
        }

        return view('livewire.school.schedules.timetables', [
            'timetables' => $timetables
        ])->extends('components.layouts.admin');
    }
}