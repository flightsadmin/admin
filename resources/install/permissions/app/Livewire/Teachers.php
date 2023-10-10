<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use App\Models\ClassModel;
use Livewire\WithPagination;
use App\Models\StudentParent;
use Livewire\WithFileUploads;

class Teachers extends Component
{ 
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $student_id, $name, $student_parent_id, $class_id, $gender, $date_of_birth, $roll_number, $keyWord, $address;

    public function render()
    {
        $keyWord = '%'. $this->keyWord .'%';
        $students = Student::with('parent', 'class')
                    ->orWhere('name', 'LIKE', $keyWord)
                    ->orWhere('roll_number', 'LIKE', $keyWord)
                    ->paginate();
        return view('livewire.school.students.view', [
            'students' => $students,
            'classes' => ClassModel::all(),
            'parents' => StudentParent::all()
        ])->extends('components.layouts.admin');
    }
    
    public function saveStudent()
    {
        $validatedData = $this->validate([
            'name'      => 'required',
            'student_parent_id' => 'nullable',
            'class_id'  => 'nullable',
            'roll_number' => 'required|min:2',
            'gender'    => 'required',
            'address'   => 'required',
            'date_of_birth'=> 'required|date'
        ]);

        Student::updateOrCreate(['id' => $this->student_id], $validatedData);

        $this->dispatch('closeModal');
        session()->flash('message', 'Student created successfully.');
        $this->reset();
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $this->student_id = $id;
        $this->name = $student->name;
        $this->student_parent_id = $student->student_parent_id;
        $this->class_id = $student->class_id;
        $this->roll_number = $student->roll_number;
        $this->gender = $student->gender;
        $this->address = $student->address;
        $this->date_of_birth = $student->date_of_birth;
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        session()->flash('message', 'Student Deleted Successfully.');
    }

    public function createPaent($email)
    {
        $this->validate([
            'name' => 'required|min:4',
            '' =>  ''
        ]);
    }
}