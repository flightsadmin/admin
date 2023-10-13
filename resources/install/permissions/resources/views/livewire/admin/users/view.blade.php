@section('title', 'Users')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h5>Users</h5>
                    @can('createUser')
                        <button data-bs-toggle="modal" data-bs-target="#dataModal"
                            class="btn btn-sm btn-primary float-end align-items-center bi bi-person-add">
                            Add User
                        </button>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @include('livewire.admin.users.modals')
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Title</th>
                                <th>Roles</th>
                                <th>Picture</th>
                                <th width="120">Actions</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr wire:key="{{ $user->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->title }}</td>
                                    <td>
                                        @foreach ($user->roles as $role)
                                            <button class="btn btn-warning custom-btn-sm bi bi-shield-shaded"> {{ $role->name }}</button>
                                        @endforeach
                                    </td>
                                    <td class="text-center"><img class="profile-img" src="{{ asset('storage/' . $user->photo) }}"
                                            alt="{{ $user->title }}"></td>
                                    <td class="text-center">
                                        <button data-bs-toggle="modal" data-bs-target="#viewModal"
                                            class="btn btn-info custom-btn-sm text-white bi bi-eye" wire:click="edit({{ $user->id }})">
                                        </button>
                                        @if (
                                            $user->id == auth()->user()->id ||
                                                auth()->user()->can('editUser'))
                                            <button data-bs-toggle="modal" data-bs-target="#dataModal"
                                                class="btn btn-primary custom-btn-sm bi bi-pencil-square"
                                                wire:click="edit({{ $user->id }})"> </button>
                                            @can('deleteUser')
                                                <button class="btn btn-danger custom-btn-sm text-white bi bi-trash3-fill"
                                                    wire:click.prevent="destroy({{ $user->id }})"
                                                    wire:confirm="Are you sure you want to delete this User?"> </button>
                                            @endcan
                                        @endif
                                    <td>
                                        {{ $user->created_at->format('d-M-Y H:i:s') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="float-end">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
</div>
