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
use Spatie\Permission\Models\Permission;

class Users extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $userId, $name, $email, $photo, $phone, $title, $password, $password_confirmation, $changePassword, $selectedRoles = [];

    public function render()
    {
        return view('livewire.users.view', [
            'users' => User::latest()->paginate(),
            'roles' => Role::with('permissions')->get()
        ]);
    }

    public function submit()
    {
        $validatedData = $this->validate([
            'name'          => 'required|min:6',
            'email'         => 'required|email',
            'phone'         => 'nullable|regex:/^\+?\d{9,11}$/',
            'title'         => 'nullable|min:6',
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
        $this->dispatch('closeModal');
        session()->flash('message', $this->userId ? 'User Updated Successfully.' : 'User Created Successfully.');
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

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);

        if($user->photo != 'users/noimage.jpg') {
            Storage::disk('public')->delete($user->photo);
        }
        $user->delete();
    }
}