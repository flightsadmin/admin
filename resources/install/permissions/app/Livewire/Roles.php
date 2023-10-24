<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Roles extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name, $role_id, $permissions_selection = [];

    public function render()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::with('roles')->get();

        return view('livewire.admin.roles.view', [
            'roles' => $roles,
            'permissions' => $permissions,
        ])->extends('components.layouts.admin');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|min:3|max:100',
        ]);

        $role = Role::updateOrCreate(['id' => $this->role_id], [
            'name' => $this->name,
            'guard_name' => config('auth.defaults.guard')
        ]);
        $role->permissions()->sync($this->permissions_selection);
        $this->reset();
        $this->dispatch('closeModal');
        session()->flash('message', $this->role_id ? 'Role Updated Successfully.' : 'Role Created Successfully.');
    }

    public function edit($id)
    {
        $record = Role::findOrFail($id);
        $this->role_id = $id;
        $this->name = $record->name;
        $this->guard_name = $record->guard_name;
        $this->permissions_selection = $record->permissions()->pluck('id')->toArray();
    }

    public function destroy(Role $role)
    {
        $role->delete();
        session()->flash('message', 'Role Deleted Successfully.');
    }
}