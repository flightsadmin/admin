<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name, $permission_id;

    public function render()
    {
        $permissions = Permission::with('roles')->paginate();
        return view('livewire.admin.permissions.view', [
            'permissions' => $permissions,
        ])->extends('components.layouts.admin');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|min:3|max:100',
        ]);

        Permission::updateOrCreate(['id' => $this->permission_id], [
            'name' => $this->name,
            'guard_name' => config('auth.defaults.guard')
        ]);
        $this->alert();
        $this->reset();
    }

    public function edit($id)
    {
        $record = Permission::findOrFail($id);
        $this->permission_id = $id;
        $this->name = $record->name;
        $this->guard_name = $record->guard_name;
    }

    public function alert() {
        $this->dispatch(
            'closeModal',
            icon: "success",
            message: $this->board_id ? 'Permission Updated Successfully.' : 'Permission Created Successfully.',
        );
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        $this->dispatch(
            'closeModal',
            icon: "info",
            message: 'Permission Deleted Successfully.',
        );
    }
}