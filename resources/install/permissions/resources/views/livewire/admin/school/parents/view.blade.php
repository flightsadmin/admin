@section('title', __('Parents'))
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="card-title">Parents</h3>
                    <div>
                        <input wire:model.live.debounce.500ms="keyWord" type="text" class="form-control form-control-sm" name="search"
                            id="search" placeholder="Search Parent">
                    </div>
                    <div class="btn btn-sm btn-info bi bi-plus-lg" data-bs-toggle="modal" data-bs-target="#dataModal">
                        Add Parent
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('livewire.admin.school.parents.modals')
                <div class="row">
                    <div>
                        <div id="toast-container" class="toast-top-right"></div>
                    </div>
                    @forelse($parents as $row)
                        <div class="col-md-6 border d-flex justify-content-between">
                            <div class="col-md-8 mt-2">
                                <div class="fw-bold">Name: {{ $row->name }}</div>
                                <div> Email: {{ $row->email }}</div>
                                <div> Phone: {{ $row->phone }}</div>
                                <label>Students:</label>
                                <ol>
                                    @forelse ($row->students as $student)
                                        <li>{{ $student->name }}</li>
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
                                                class="dropdown-item bi bi-pencil-square" wire:click.prevent="edit({{ $row->id }})">
                                                Edit </a></li>
                                        <li><a href="" class="dropdown-item bi bi-trash3"
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
@push('scripts')
    <script type="module">
        document.addEventListener('livewire:navigated', () => {
            const genModal = new bootstrap.Modal('#dataModal');
            @this.on('closeModal', (message) => {
                genModal.hide();
                Toastify({
                    text: "Parent Record Updated Successfully.",
                    duration: 3000,
                    close: true,
                }).showToast();
            });
        });
    </script>
@endpush
