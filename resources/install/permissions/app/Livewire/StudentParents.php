<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StudentParent;
use Livewire\WithFileUploads;

class StudentParents extends Component
{ 
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $parent_id, $name, $email, $phone, $keyWord;

    public function render()
    {
        $keyWord = '%'. $this->keyWord .'%';
        $parents = StudentParent::with('students')
                    ->orWhere('name', 'LIKE', $keyWord)
                    ->orWhere('email', 'LIKE', $keyWord)
                    ->paginate();
        return view('livewire.admin.school.parents.view', [
            'parents' => $parents
        ])->extends('components.layouts.admin');
    }
    
    public function save()
    {
        $validatedData = $this->validate([
            'name'   => 'required',
            'email'  => 'required|email',
            'phone'  => 'nullable'
        ]);

        StudentParent::updateOrCreate(['id' => $this->parent_id], $validatedData);

        $this->dispatch('closeModal');
        session()->flash('message', 'StudentParent created successfully.');
        $this->reset();
    }

    public function edit($id)
    {
        $parent = StudentParent::findOrFail($id);
        $this->parent_id = $id;
        $this->name = $parent->name;
        $this->email = $parent->email;
        $this->phone = $parent->phone;
    }

    public function destroy($id)
    {
        StudentParent::findOrFail($id)->delete();
        session()->flash('message', 'StudentParent Deleted Successfully.');
    }
}
