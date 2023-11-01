<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class Users extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $userId, $name, $email, $photo, $phone, $title, $password, $password_confirmation, $changePassword, $selectedRoles = [];

    public function render()
    {
        return view('livewire.admin.users.view', [
            'users' => User::whereIn('title', ['super-admin', 'admin', 'user', 'principal'])->latest()->paginate(),
            'roles' => Role::with('permissions')->get()
        ])->extends('components.layouts.admin');
    }

    public function submit()
    {
        $validatedData = $this->validate([
            'name'          => 'required|min:5',
            'email'         => 'required|email',
            'phone'         => 'nullable|min:10|max:13',
            'title'         => 'required',
            'selectedRoles' => 'required',
            'password'      => $this->userId ? 'nullable' : 'required|confirmed',
            'photo'         => $this->userId ? 'nullable' : 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        if ($this->photo && !is_string($this->photo)) {
        $validatedData['photo'] = $this->photo->storeAs('users', explode('@', $validatedData['email'])[0] . '.'.$this->photo->getClientOriginalExtension() , 'public');
        } else {
            unset($validatedData['photo']);
        }
        if (!empty($this->password)) {
            $validatedData['password'] = Hash::make($this->password);
        } else {
            unset($validatedData['password']);
        }

        $user = User::updateOrCreate(['id' => $this->userId], $validatedData);
        $user->syncRoles($this->selectedRoles);
        
        if($user->wasRecentlyCreated){
            $emailData = [
                'name'      => $this->name,
                'email'     => $this->email,
                'phone'     => $this->phone,
                'roles'     => $user->roles->pluck('name')->toArray(),
                'password'  => $this->password
            ];
            
            Mail::send('mails.email', $emailData, function($message) use($emailData) {
                $message->to($emailData['email'], $emailData['name'])
                ->subject('New Account for '. $emailData['name']);
            });
        }
        $this->alert();
        $this->reset();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name  = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->photo = $user->photo;
        $this->title = $user->title;
        $this->selectedRoles = $user->roles->pluck('id')->toArray();
    }

    public function alert() {
        $this->dispatch(
            'closeModal',
            icon: "success",
            message: $this->userId ? 'User Updated Successfully.' : 'User Created Successfully.',
        );
    }

    public function details() {
        $user = auth()->user();
        return view('livewire.admin.users.details', compact('user'));
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if($user->photo != 'users/noimage.jpg') {
            Storage::disk('public')->delete($user->photo);
        }
        $user->delete();

        $this->dispatch(
            'closeModal',
            icon: "info",
            message: "User Deleted Successfully.",
        );
    }
}