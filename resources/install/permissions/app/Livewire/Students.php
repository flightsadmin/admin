<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use App\Models\Grade;
use Livewire\WithPagination;
use App\Models\Guardian;
use Livewire\WithFileUploads;

class Students extends Component
{ 
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $student_id, $name, $guardian_id, $grade_id, $gender, $date_of_birth, $roll_number, $keyWord, $address;

    public function render()
    {
        $keyWord = '%'. $this->keyWord .'%';
        $students = Student::with('parent', 'grade')
                    ->orWhere('name', 'LIKE', $keyWord)
                    ->orWhere('roll_number', 'LIKE', $keyWord)
                    ->paginate();
        return view('livewire.admin.school.students.view', [
            'students' => $students,
            'classes' => Grade::all(),
            'parents' => Guardian::all()
        ])->extends('components.layouts.admin');
    }
    
    public function save()
    {
        $validatedData = $this->validate([
            'name'      => 'required',
            'guardian_id' => 'nullable',
            'grade_id'  => 'nullable',
            'roll_number' => 'required|min:2',
            'gender'    => 'required',
            'address'   => 'required',
            'date_of_birth'=> 'required|date'
        ]);

        Student::updateOrCreate(['id' => $this->student_id], $validatedData);

        $this->alert();
        $this->reset();
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $this->student_id = $id;
        $this->name = $student->name;
        $this->guardian_id = $student->guardian_id;
        $this->grade_id = $student->grade_id;
        $this->roll_number = $student->roll_number;
        $this->gender = $student->gender;
        $this->address = $student->address;
        $this->date_of_birth = $student->date_of_birth;
    }

    public function home()
    {
        return view('home');
    }

    public function details($id) {
        $student = Student::findOrFail($id);
        return view('livewire.admin.school.students.details', [
            'student' => $student
        ]);
    }

    public function alert() {
        $this->dispatch(
            'closeModal',
            icon: "success",
            message: $this->student_id ? 'Student Updated Successfully.' : 'Student Created Successfully.',
        );
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        $this->dispatch(
            'closeModal',
            icon: "info",
            message: "Student deleted Successfully.",
        );
    }
}