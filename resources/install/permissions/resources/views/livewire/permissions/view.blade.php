<div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            @if($dataForm)<h4>{{ $permission->id ? 'Edit' : 'Create' }} Permission </h4> @else <h4>Permissions</h4> @endif
                            <button class="btn btn-sm btn-primary float-end bi bi-plus-circle" wire:click="dataForm()">
                                Add Permission
                            </button>
                        </div>
                    </div>

                    @if($dataForm)
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row g-2 mb-3">
                                    <div class="col-md-12">
                                    <label class="h5" for="permission.name">Permissions Name <span class="text-danger small">*</span></label>
                                        <input type="text" wire:model.blur="permission.name" class="form-control">
                                        @error('permission.name') <span class="text-danger small">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="mt-3" style="display: flex; justify-content: space-between; align-items: center;">
                                        <button class="btn btn-sm btn-info bi bi-x-circle" wire:click="index()"> Cancel</button>
                                        <button class="btn btn-sm btn-success bi bi-check-circle" wire:click="save()"> Save Permission</button>
                                    </div>
                                </div>
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
                                    <th>Roles</th>
                                    <th width="40"></th>
                                    <th width="40"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $permission)
                                <tr wire:key="{{ $permission->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        @foreach($permission->roles as $role)
                                            <button class="btn btn-warning custom-btn-sm mb-1 bi bi-shield-shaded"> {{ $role->name }}</button>
                                        @endforeach
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary custom-btn-sm bi bi-pencil-square" wire:click="dataForm({{$permission}})"> </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger custom-btn-sm bi bi-trash" 
                                            onclick="confirm('Are you shure want to delete permision: {{ $permission->name }}?') || event.stopImmediatePropagation()" 
                                            wire:click="delete({{$permission}})">
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="float-end">{{ $permissions->links() }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message Toast  -->
    <div  id="statusToast" class="toast position-fixed top-0 end-0 p-3 text-bg-success" style="margin-top:5px; margin-bottom:0px;" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header text-bg-success">
        <i class="me-2 bi bi-send-fill"></i>
        <strong class="me-auto text-black">Success</strong>
        <small class="text-white">{{ now() }}</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body text-black text-center">
        {{ session('message') }}
    </div>
    </div>
</div>