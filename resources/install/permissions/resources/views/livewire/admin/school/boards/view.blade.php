@section('title', __('Notice'))
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header py-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="card-title">Notice</h3>
                    <div>
                        <input wire:model.live.debounce.500ms="keyWord" type="text" class="form-control form-control-sm" name="search"
                            id="search" placeholder="Search Notice">
                    </div>
                    <div class="btn btn-sm btn-info bi bi-plus-lg" data-bs-toggle="modal" data-bs-target="#dataModal">
                        Add Notice
                    </div>
                </div>
            </div>
            <div class="card-body">
                @include('livewire.admin.school.boards.modals')
                <div class="row">
                    <div>
                        <div id="toast-container" class="toast-top-right"></div>
                    </div>
                    @forelse($boards as $row)
                        <div wire:key="$row->id" class="col-md-12 border d-flex justify-content-between">
                            <div class="col-md-10 mt-2">
                                <h2 class="fw-bold">{{ $row->title }}</h2>
                                <hr>
                                <div>{!! $row->body !!}</div>
                            </div>
                            <div class="col-md-2 mt-2">
                                <div class="dropdown float-end">
                                    <a class="btn custom-btn-sm text-white btn-secondary dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="" data-bs-toggle="modal" data-bs-target="#dataModal"
                                            class="dropdown-item bi bi-pencil-square" wire:click.prevent="edit({{ $row->id }})">
                                            Edit </a></li>
                                        <li><a wire:navigate href="{{ route('admin.notices.show', ['id' => $row->id]) }}"
                                            style="text-decoration: none;" class="dropdown-item bi bi-eye-fill"> View</a></li>                                        
                                        <li><a href="" class="dropdown-item bi bi-trash3"
                                                wire:click.prevent="destroy({{ $row->id }})"
                                                wire:confirm="Are you sure you want to delete this Notice?"> Delete </a></li>
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
                <div class="float-end mt-2 mb-0">{{ $boards->links() }}</div>
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
    </script>
@endpush