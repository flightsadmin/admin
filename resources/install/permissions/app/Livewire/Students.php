<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Grade;
use App\Models\Student;
use Livewire\Component;
use App\Models\Guardian;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class Students extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $student_id, $name, $guardian_id, $grade_id, $gender, $date_of_birth, $username, $keyWord, $address;

    public function render()
    {
        $students = Student::with('parent', 'grade')->paginate();
        return view('livewire.admin.school.students.view', [
            'students' => $students,
            'classes' => Grade::all(),
            'parents' => Guardian::all()
        ])->extends('components.layouts.admin');
    }

    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'guardian_id' => 'nullable',
            'grade_id' => 'nullable',
            'username' => 'required|min:2',
            'gender' => 'required',
            'date_of_birth' => 'required|date',
            'address' => 'required',
        ]);

        try {
            DB::transaction(function () use ($validatedData) {
                $user = User::updateOrCreate(['username' => $this->username], [
                    'name' => $validatedData['name'],
                    'username' => $validatedData['username'],
                    'title' => 'Student',
                    'password' => bcrypt('password')
                ])->assignRole('student');

                $user->student()->updateOrCreate(['id' => $this->student_id], [
                    'user_id' => $user->id,
                    'guardian_id' => $validatedData['guardian_id'],
                    'grade_id' => $validatedData['grade_id'],
                    'gender' => $validatedData['gender'],
                    'date_of_birth' => $validatedData['date_of_birth'],
                    'address' => $validatedData['address'],
                ]);
                $this->alert();
                $this->reset();
            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $this->student_id = $id;
        $this->name = $student->user->name;
        $this->guardian_id = $student->guardian_id;
        $this->grade_id = $student->grade_id;
        $this->username = $student->user->username;
        $this->gender = $student->gender;
        $this->address = $student->address;
        $this->date_of_birth = $student->date_of_birth;
    }

    public function home()
    {
        return view('home');
    }

    public function details($id)
    {
        $student = Student::findOrFail($id);
        return view('livewire.admin.school.students.details', [
            'student' => $student
        ]);
    }

    public function alert()
    {
        $this->dispatch(
            'closeModal',
            icon: "success",
            message: $this->student_id ? 'Student Updated Successfully.' : 'Student Created Successfully.',
        );
    }

    public function generateUserName()
    {
        if ($this->username) {
            return;
        }
        $lastStaff = User::max('id');
        $this->username = setting('site_short_code') . '/' . date('Y') . '/' . str_pad($lastStaff + 1, 5, 0, STR_PAD_LEFT);
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