<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Roles extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $form = false;
    public Role $role;
    public $permissions_selection;

    protected function rules()
    {
        return [
            'role.name'        => 'required|min:3|max:100',
            'role.guard_name'  => 'required',
        ];
    }

    public function index()
    {
        $this->resetErrorBag();
        $this->form = false;
    }

    public function form(Role $role)
    {
        $this->role = Role::firstOrNew([
            'name' => $role->name, 
            'guard_name' => config('auth.defaults.guard')
        ]);
        $this->permissions_selection = $this->role->permissions()->pluck('id')->toArray();
        $this->form = true;
    }

    public function save()
    {
        $this->validate();
        $this->role->save();
        $this->role->permissions()->sync($this->permissions_selection);
        
        $this->dispatch('closeModal');
        session()->flash('message', 'Role created successfully.');
        $this->index();
    }

    public function delete(Role $role)
    {
        $role->delete();
    }

    public function render()
    {
        $roles = Role::with('permissions')->paginate();
        $permissions = Permission::with('roles')->paginate();

        return view('livewire.roles.view', [
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }
}