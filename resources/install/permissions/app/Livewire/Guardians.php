<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Guardian;
use Livewire\WithFileUploads;

class Guardians extends Component
{ 
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $parent_id, $name, $email, $phone, $keyWord;

    public function render()
    {
        $keyWord = '%'. $this->keyWord .'%';
        $parents = Guardian::with('students')
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

        Guardian::updateOrCreate(['id' => $this->parent_id], $validatedData);

        $this->dispatch('closeModal');
        session()->flash('message', 'Guardian created successfully.');
        $this->reset();
    }

    public function edit($id)
    {
        $parent = Guardian::findOrFail($id);
        $this->parent_id = $id;
        $this->name = $parent->name;
        $this->email = $parent->email;
        $this->phone = $parent->phone;
    }

    public function details($id) {
        $parent = Guardian::findOrFail($id);
        return view('livewire.admin.school.parents.details', [
            'parent' => $parent
        ]);
    }

    public function destroy($id)
    {
        Guardian::findOrFail($id)->delete();
        session()->flash('message', 'Guardian Deleted Successfully.');
    }
}