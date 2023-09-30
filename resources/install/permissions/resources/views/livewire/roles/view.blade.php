@section('title', 'Roles')
<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        @if($form)<h5>{{ $role->id ? 'Edit' : 'Create' }} Role </h5> @else <h4>Roles</h4> @endif
                        <button class="btn btn-sm btn-primary float-end bi bi-plus-circle" wire:click="form()">
                            Add Role
                        </button>
                    </div>
                </div>
            @if($form)
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row g-2 mb-3">
                                <div class="col-md-12">
                                    <label class="h4" for="role.name">Role Name <span class="text-danger small">*</span></label>
                                    <input type="text" wire:model.blur="role.name" class="form-control">
                                    @error('role.name') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="mt-3" style="display: flex; justify-content: space-between; align-items: center;">
                                    <button class="btn btn-sm btn-info bi bi-x-circle" wire:click="index()"> Cancel</button>
                                    <button class="btn btn-sm btn-success bi bi-check-circle" wire:click="save()"> Save Role</button>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-6">
                            <h4 class="">Assign Permissions</h4>
                            <table class="table table-sm table-bordered">
                                <tbody>
                                    @foreach($permissions as $permission)
                                    <tr wire:key="{{ $permission->id }}">
                                        <td width="40">
                                            <input class="form-check-input" type="checkbox" 
                                                wire:model.blur="permissions_selection" 
                                                value="{{ $permission->id }}" 
                                                id="permission_{{ $permission->id }}">
                                        </td>
                                        <td>
                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                <strong>{{ $permission->name }}</strong>
                                            </label>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else()
                <div class="card-body">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Permissions</th>
                                <th width="40"></th>
                                <th width="40"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr wire:key="{{ $role->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @foreach($role->permissions as $permission)
                                        <button class="btn btn-warning label-btn-sm custom-btn-sm mb-1 bi bi-shield-shaded"> {{ $permission->name }}</button>
                                    @endforeach
                                </td>
                                <td>
                                    <button class="btn btn-primary custom-btn-sm bi bi-pencil-square" wire:click="form({{$role}})"></button>
                                </td>
                                <td>
                                    <button class="btn btn-danger custom-btn-sm bi bi-trash" 
                                        onclick="confirm('Are you shure want to delete role: {{ $role->name }}?') || event.stopImmediatePropagation()" 
                                        wire:click="delete({{ $role }})">
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="float-end">{{ $roles->links() }}</div>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>