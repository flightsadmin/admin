@section('title', __('Teachers'))
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header py-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="card-title">Teachers</h3>
                    <div>
                        <input wire:model.live.debounce.500ms="keyWord" type="text" class="form-control form-control-sm" name="search"
                            id="search" placeholder="Search Teacher">
                    </div>

                    <div class="btn btn-sm btn-info bi-plus-lg" data-bs-toggle="modal" data-bs-target="#dataModal">
                        Add Teacher
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('livewire.school.teachers.modals')
                <div class="row">
                    @forelse($teachers as $row)
                        <div class="col-md-6 border d-flex justify-content-between">
                            <div class="col-md-8 mt-2">
                                <b><i class="bi-person-circle text-info"></i> {{ $row->user->name }}</b>
                                <div>Staff Number: {{ $row->staff_number }}</div>
                                <div>Gender: {{ ucwords($row->gender) }}</div>
                                <div>Address: {{ $row->address }}</div>
                            </div>

                            <div class="col-md-2 mt-2">
                                <div class="dropdown float-end">
                                    <a class="btn custom-btn-sm text-white btn-secondary dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="" data-bs-toggle="modal" data-bs-target="#dataModal"
                                                class="dropdown-item bi-pencil-square" wire:click.prevent="edit({{ $row->id }})">
                                                Edit </a></li>
                                        <li><a wire:navigate href="{{ route('admin.teachers.show', ['id' => $row->id]) }}"
                                                class="dropdown-item bi-eye-fill"> View</a></li>
                                        <li><a href="" class="dropdown-item bi-trash3"
                                                wire:click.prevent="destroy({{ $row->id }})"
                                                wire:confirm="Are you sure you want to delete this Teacher?"> Delete </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <p class="text-center">No Teachers Created Yet</p>
                        </div>
                    @endforelse
                </div>
                <div class="float-end mt-2 mb-0">{{ $teachers->links() }}</div>
            </div>
        </div>
    </div>
</div>