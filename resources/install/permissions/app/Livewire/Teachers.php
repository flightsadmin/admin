<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Teachers extends Component
{ 
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $teacher_id, $name, $subjects = [], $grades = [], $gender, $date_of_birth, $staff_number, $keyWord, $address;

    public function render()
    {
        $keyWord = '%'. $this->keyWord .'%';
        $teachers = Teacher::with('classes', 'subjects')
                    ->orWhere('name', 'LIKE', $keyWord)
                    ->orWhere('staff_number', 'LIKE', $keyWord)
                    ->paginate();
        return view('livewire.admin.school.teachers.view', [
            'teachers'  => $teachers,
            'classes'    => Grade::all(),
            'lessons'   => Subject::all()
        ])->extends('components.layouts.admin');
    }
    
    public function save()
    {
        $validatedData = $this->validate([
            'name'      => 'required',
            'staff_number' => 'required|min:2',
            'gender'    => 'required',
            'address'   => 'required',
            'date_of_birth'=> 'required|date'
        ]);

        $teacher = Teacher::updateOrCreate(['id' => $this->teacher_id], $validatedData);
        $teacher->classes()->sync($this->grades);
        $teacher->subjects()->sync($this->subjects);

        $this->dispatch('closeModal');
        session()->flash('message',  $this->teacher_id ? 'Teacher Updated Successfully.' : 'Teacher Created Successfully.');
        $this->reset();
    }

    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        $this->teacher_id = $id;
        $this->name = $teacher->name;
        $this->subjects = $teacher->subjects->pluck('id')->toArray();
        $this->grades = $teacher->classes->pluck('id')->toArray();
        $this->staff_number = $teacher->staff_number;
        $this->gender = $teacher->gender;
        $this->address = $teacher->address;
        $this->date_of_birth = $teacher->date_of_birth;
    }

    public function details($id) {
        $teacher = Teacher::findOrFail($id);
        return view('livewire.admin.school.teachers.details', [
            'teacher' => $teacher
        ]);
    }

    public function destroy($id)
    {
        Teacher::findOrFail($id)->delete();
        session()->flash('message', 'Teacher Deleted Successfully.');
    }
}