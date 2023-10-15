@section('title', 'Permissions')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="card-title"> Permissions</div>
                    @if (session()->has('message'))
                        <div wire:poll class="btn btn-sm btn-success" style="margin-top:0px; margin-bottom:0px;">
                            {{ session('message') }}
                        </div>
                    @endif
                    <div class="btn btn-sm btn-info bi bi-plus-lg" data-bs-toggle="modal" data-bs-target="#dataModal">
                        Add Permission
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('livewire.admin.permissions.modals')
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Permission</th>
                                <th width="40"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permissions as $permission)
                                <tr wire:key="{{ $permission->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        @foreach ($permission->roles as $role)
                                            <button class="btn btn-warning custom-btn-sm mb-1 bi bi-shield-shaded">
                                                {{ $role->name }}</button>
                                        @endforeach
                                    </td>
                                    <td width="90">
                                        <div class="dropdown">
                                            <a class="btn custom-btn-sm btn-secondary dropdown-toggle" href="#" role="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a data-bs-toggle="modal" data-bs-target="#dataModal"
                                                        class="dropdown-item bi bi-pencil-square"
                                                        wire:click="edit({{ $permission->id }})"> Edit </a>
                                                </li>
                                                <li><a class="dropdown-item bi bi-trash3"
                                                        wire:click.prevent="destroy({{ $permission->id }})"
                                                        wire:confirm="Are you sure you want to delete this Permission?"> Delete </a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">No Permissions Found </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="float-end mt-2 mb-0">{{ $permissions->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
