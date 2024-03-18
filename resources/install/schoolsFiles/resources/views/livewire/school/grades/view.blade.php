@section('title', __('Class'))
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header py-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="card-title">Class</h3>
                    <div>
                        <select class="form-select" id="keyWord" wire:model.live="keyWord">
                            <option value="">Select Class</option>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="btn btn-sm btn-info bi-plus-lg" data-bs-toggle="modal" data-bs-target="#dataModal">
                        Add Class
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('livewire.school.grades.modals')
                <div class="row">
                    @forelse($grades as $row)
                        <div class="col-md-6 border d-flex justify-content-between">
                            <div class="col-md-8 mt-2">
                                <div class="fw-bold">Class Name: {{ $row->name }}</div>
                                <div> Students:</div>
                                <ol>
                                    @foreach($row->students as $student)
                                        <li>
                                            {{ $student->user->name }} ({{ $student->user->username }})
                                        </li>
                                    @endforeach
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
                                        <li><a wire:navigate href="{{ route('admin.grades.show', ['id' => $row->id]) }}"
                                            class="dropdown-item bi-eye-fill"> View</a></li>
                                        <li><a href="" class="dropdown-item bi-trash3"
                                                wire:click.prevent="destroy({{ $row->id }})"
                                                wire:confirm="Are you sure you want to delete this Class?"> Delete </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <p class="text-center">No Classs Created Yet</p>
                        </div>
                    @endforelse
                </div>
                <div class="float-end mt-2 mb-0">{{ $grades->links() }}</div>
            </div>
        </div>
    </div>
</div>