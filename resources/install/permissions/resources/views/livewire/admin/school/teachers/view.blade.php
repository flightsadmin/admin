@section('title', __('Teachers'))
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 class="card-title">Teachers</h3>
                    <div>
                        <input wire:model.live.debounce.500ms="keyWord" type="text" class="form-control form-control-sm" name="search"
                            id="search" placeholder="Search Teacher">
                    </div>
                    <div class="btn btn-sm btn-info bi bi-plus-lg" data-bs-toggle="modal" data-bs-target="#dataModal">
                        Add Teacher
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('livewire.admin.school.teachers.modals')
                <div class="row">
                    @forelse($teachers as $row)
                        <div class="col-md-6 border d-flex justify-content-between">
                            <div class="col-md-8 mt-2">
                                <b><i class="bi bi-person-circle text-info"></i> {{ $row->name }} - {{ $row->staff_number }}</b>
                                <div>Gender: {{ ucwords($row->gender) }}</div>
                                <div>Address: {{ $row->address }}</div>
                                <b>Classes:</b>
                                @foreach ($row->classes as $item)
                                    <div class="badge rounded-pill text-bg-secondary me-2">{{ $item->name }}</div>
                                @endforeach
                                <hr class="m-1">
                                <b>Subjects:</b>
                                @foreach ($row->subjects as $item)
                                    <div class="badge rounded-pill text-bg-secondary me-2">{{ $item->name }}</div>
                                @endforeach
                            </div>
                            <div class="col-md-4 mt-2">
                                <div class="dropdown float-end">
                                    <a class="btn custom-btn-sm text-white btn-secondary dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="" data-bs-toggle="modal" data-bs-target="#dataModal"
                                                class="dropdown-item bi bi-pencil-square" wire:click.prevent="edit({{ $row->id }})">
                                                Edit </a></li>
                                        <li><a href="" class="dropdown-item bi bi-trash3"
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
@push('scripts')
    <script type="module">
        const genModal = new bootstrap.Modal('#dataModal');
        window.addEventListener('closeModal', () => {
            genModal.hide();
        });

        const toast = new bootstrap.Toast('#statusToast');
        window.addEventListener('closeModal', () => {
            toast.show();
        });
    </script>
@endpush
