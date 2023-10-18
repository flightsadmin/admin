@section('title', __('Roles'))
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="card-title"> Roles</div>

                    <div class="btn btn-sm btn-info bi bi-plus-lg" data-bs-toggle="modal" data-bs-target="#dataModal">
                        Add Role
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('livewire.admin.roles.modals')
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Permissions</th>
                                <th width="40"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr wire:key="{{ $role->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @foreach ($role->permissions as $permission)
                                            <button class="btn btn-warning label-btn-sm custom-btn-sm mb-1 bi bi-shield-shaded">
                                                {{ $permission->name }}</button>
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
                                                        wire:click="edit({{ $role->id }})"> Edit </a>
                                                </li>
                                                <li><a class="dropdown-item bi bi-trash3"
                                                        wire:click.prevent="destroy({{ $role->id }})"
                                                        wire:confirm="Are you sure you want to delete this Role?"> Delete </a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">No Roles Found </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
