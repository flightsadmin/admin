<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Guardian;
use Livewire\WithPagination;
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

        $guardian = Guardian::updateOrCreate(['id' => $this->parent_id], $validatedData);
        if($guardian->wasRecentlyCreated){
            $user = new User([
                'name' => $guardian->name,
                'email' => $guardian->email,
                'phone' => $guardian->phone,
                'title' => 'Guardian',
                'password' => bcrypt('password'),
            ]);
            
            $user->save();
            $user->roles()->sync(['1']);
        }

        $this->alert();
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

    public function alert() {
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