@section('title', __('Students'))
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header py-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="card-title">Students</h3>
                    <div class="btn btn-sm btn-info bi-plus-lg" data-bs-toggle="modal" data-bs-target="#dataModal">
                        Add Student
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('livewire.school.students.modals')
                <div class="row">
                    @forelse($students as $row)
                        <div class="col-md-6 border d-flex justify-content-between">
                            <div class="col-md-8 my-2">
                                <b><i class="bi-person-circle text-info"></i> {{ $row->user->name }}</b>
                                <div class="bi-person-vcard"> Registration Number: {{ $row->user->username }}</div>
                                <div>Gender: {{ ucwords($row->gender) }}</div>
                                <div>Address: {{ $row->address }}</div>
                                <b>Parent:</b>
                                <a wire:navigate href="{{ $row->parent ? route('admin.parents.show', ['id' => $row->parent->id]) : '#' }}"
                                    style="text-decoration: none;">{{ $row->parent ? $row->parent->user->name : '' }}</a>
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
                                        <li><a wire:navigate href="{{ route('admin.students.show', ['id' => $row->id]) }}"
                                                class="dropdown-item bi-eye-fill"> View</a></li>
                                        <li><a href="" class="dropdown-item bi-trash3"
                                                wire:click.prevent="destroy({{ $row->id }})"
                                                wire:confirm="Are you sure you want to delete this Student?"> Delete </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <p class="text-center">No Students Created Yet</p>
                        </div>
                    @endforelse
                </div>
                <div class="float-end mt-2 mb-0">{{ $students->links() }}</div>
            </div>
        </div>
    </div>
</div>