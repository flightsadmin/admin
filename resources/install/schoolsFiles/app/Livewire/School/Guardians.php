<?php

namespace App\Livewire\School;

use App\Models\User;
use Livewire\Component;
use App\Models\Guardian;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class Guardians extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $parent_id, $name, $email, $phone, $gender, $address;

    public function render()
    {
        $parents = Guardian::with('students', 'user')->paginate();
        return view('livewire.school.parents.view', [
            'parents' => $parents
        ])->extends('components.layouts.admin');
    }

    public function save()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required',
        ]);

        try {
            DB::transaction(function () use ($validatedData) {
                $user = User::updateOrCreate(['email' => $this->email], [
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'phone' => $validatedData['phone'],
                    'title' => 'Parent',
                    'password' => bcrypt('password')
                ])->assignRole('parent');

                $parent = $user->parent()->updateOrCreate(['id' => $this->parent_id], [
                    'user_id' => $user->id,
                    'gender' => $validatedData['gender'],
                    'address' => $validatedData['address'],
                ]);
            });
            $this->alert();
            $this->reset();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        $parent = Guardian::findOrFail($id);
        $this->parent_id = $id;
        $this->name = $parent->user->name;
        $this->email = $parent->user->email;
        $this->phone = $parent->user->phone;
        $this->gender = $parent->gender;
        $this->address = $parent->address;
    }

    public function details($id)
    {
        $parent = Guardian::findOrFail($id);
        return view('livewire.school.parents.details', [
            'parent' => $parent
        ]);
    }

    public function alert()
    {
        $this->dispatch(
            'closeModal',
            icon: "success",
            message: $this->parent_id ? 'Guardian Updated Successfully.' : 'Guardian Created Successfully.',
        );
    }

    public function destroy($id)
    {
        Guardian::findOrFail($id)->delete();
        $this->dispatch(
            'closeModal',
            icon: "info",
            message: 'Guardian Deleted Successfully.',
        );
    }
}