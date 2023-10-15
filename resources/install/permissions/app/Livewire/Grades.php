<?php

namespace App\Livewire;

use App\Models\Grade;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Grades extends Component
{ 
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $grade_id, $name, $description, $keyWord;

    public function render()
    {
        $keyWord = '%'. $this->keyWord .'%';
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
            'name'          => 'required',
            'description'   => 'required|min:10'
        ]);

        Grade::updateOrCreate(['id' => $this->grade_id], $validatedData);

        $this->dispatch('closeModal');
        session()->flash('message',  $this->grade_id ? 'Class Updated Successfully.' : 'Class Created Successfully.');
        $this->reset();
    }

    public function edit($id)
    {
        $grade = Grade::findOrFail($id);
        $this->grade_id = $id;
        $this->name = $grade->name;
        $this->description = $grade->description;
    }

    public function details($id) {
        $grade = Grade::findOrFail($id);
        return view('livewire.admin.school.grades.details', [
            'grade' => $grade
        ]);
    }

    public function destroy($id)
    {
        Grade::findOrFail($id)->delete();
        session()->flash('message', 'Grade Deleted Successfully.');
    }
}