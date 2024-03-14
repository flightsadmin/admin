<?php

namespace App\Livewire\School;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class Teachers extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $teacher_id, $name, $email, $phone, $subjects = [], $grades = [], $gender, $date_of_birth, $username, $keyWord, $address;

    public function render()
    {
        $teachers = Teacher::with('classes', 'subjects')->paginate();
        return view('livewire.admin.school.teachers.view', [
            'teachers' => $teachers,
            'classes' => Grade::all(),
            'lessons' => Subject::all()
        ])->extends('components.layouts.admin');
    }

    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'username' => 'required|min:2',
            'gender' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required|date'
        ]);

        try {
            DB::transaction(function () use ($validatedData) {
                $user = User::updateOrCreate(['username' => $this->username], [
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'phone' => $validatedData['phone'],
                    'username' => $validatedData['username'],
                    'title' => 'Teacher',
                    'password' => bcrypt('password')
                ])->assignRole('teacher');

                $teacher = $user->teacher()->updateOrCreate(['id' => $this->teacher_id], [
                    'user_id' => $user->id,
                    'gender' => $validatedData['gender'],
                    'date_of_birth' => $validatedData['date_of_birth'],
                    'address' => $validatedData['address'],
                ]);

                $teacher->classes()->sync($this->grades);
                $teacher->subjects()->sync($this->subjects);
                $this->alert();
                $this->reset();
            });
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        $this->teacher_id = $id;
        $this->name = $teacher->user->name;
        $this->email = $teacher->user->email;
        $this->phone = $teacher->user->phone;
        $this->username = $teacher->user->username;
        $this->subjects = $teacher->subjects->pluck('id')->toArray();
        $this->grades = $teacher->classes->pluck('id')->toArray();
        $this->gender = $teacher->gender;
        $this->address = $teacher->address;
        $this->date_of_birth = $teacher->date_of_birth;
    }

    public function details($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('livewire.admin.school.teachers.details', [
            'teacher' => $teacher
        ]);
    }

    public function alert()
    {
        $this->dispatch(
            'closeModal',
            icon: "success",
            message: $this->teacher_id ? 'Teacher Updated Successfully.' : 'Teacher Created Successfully.',
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
        Teacher::findOrFail($id)->delete();
        $this->dispatch(
            'closeModal',
            icon: "info",
            message: "Teacher Deleted Successfully.",
        );
    }
}