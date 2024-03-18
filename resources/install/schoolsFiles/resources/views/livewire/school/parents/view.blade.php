@section('title', __('Parents'))
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header py-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="card-title">Parents</h3>
                    <div class="btn btn-sm btn-info bi-plus-lg" data-bs-toggle="modal" data-bs-target="#dataModal">
                        Add Parent
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('livewire.school.parents.modals')
                <div class="row">
                    @forelse($parents as $row)
                        <div class="col-md-6 border d-flex justify-content-between">
                            <div class="col-md-8 mt-2">
                                <div class="fw-bold">Name: {{ $row->user->name }}</div>
                                <div> Email: {{ $row->user->email }}</div>
                                <div> Phone: {{ $row->user->phone }}</div>
                                <label>Students:</label>
                                <ol>
                                    @forelse ($row->students as $student)
                                        <li>{{ $student->user->name }}</li>
                                    @empty
                                        <div class="text-warning">No Students</div>
                                    @endforelse
                                </ol>
                            </div>
                            <div class="col-md-4 mt-2">
                                <div class="dropdown float-end">
                                    <a class="btn custom-btn-sm text-white btn-secondary dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="" data-bs-toggle="modal" data-bs-target="#dataModal"
                                                class="dropdown-item bi-pencil-square" wire:click.prevent="edit({{ $row->id }})">
                                                Edit </a></li>
                                        <li><a wire:navigate href="{{ route('admin.parents.show', ['id' => $row->id]) }}"
                                            class="dropdown-item bi-eye-fill"> View</a></li>
                                        <li><a href="" class="dropdown-item bi-trash3"
                                                wire:click.prevent="destroy({{ $row->id }})"
                                                wire:confirm="Are you sure you want to delete this Parent?"> Delete </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <p class="text-center">No Parents Created Yet</p>
                        </div>
                    @endforelse
                </div>
                <div class="float-end mt-2 mb-0">{{ $parents->links() }}</div>
            </div>
        </div>
    </div>
</div>