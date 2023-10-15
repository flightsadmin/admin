<!-- Create / Edit Role Modal -->
<div wire:ignore.self class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">
                    {{ $role_id ? 'Edit Role' : 'Create New Role' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row g-2 mb-3">
                                <div class="col-md-12">
                                    <label class="card-title" for="name">Role Name <span class="text-danger small">*</span></label>
                                    <input type="text" wire:model.blur="name" class="form-control form-control-sm">
                                    @error('name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h4 class="card-title">Assign Permissions</h4>
                        <div class="col-md-12">
                            <div class="row">
                                @foreach ($permissions as $permission)
                                    <div wire:key="{{ 'permission_' . $permission->id }}" class="col-md-4 bordered">
                                        <input class="form-check-input me-2" type="checkbox"
                                            wire:model="permissions_selection"
                                            value="{{ $permission->id }}"
                                            id="permission_{{ $permission->id }}">
                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                            <strong>{{ $permission->name }}</strong>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button wire:click.prevent="store" type="button" class="btn btn-sm btn-primary bi bi-check2-circle"> Save</button>
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