<!-- Create / Edit Permission Modal -->
<div wire:ignore.self class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">
                    {{ $permission_id ? 'Edit Permission' : 'Create New Permission' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row g-2 mb-3">
                                <div class="col-md-12">
                                    <label class="card-title" for="name">Permission Name <span class="text-danger small">*</span></label>
                                    <input type="text" wire:model.blur="name" class="form-control form-control-sm">
                                    @error('name')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>                    
                </form>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button wire:click.prevent="store" type="button" class="btn btn-sm btn-primary bi-check2-circle"> Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Message Toast  -->
<div id="statusToast" class="toast position-fixed top-0 end-0 p-3 text-bg-success" style="margin-top:5px; margin-bottom:0px;" role="alert"
    aria-live="assertive" aria-atomic="true">
    <div class="toast-header text-bg-success">
        <i class="me-2 bi-send-fill"></i>
        <strong class="me-auto text-black">Success</strong>
        <small class="text-white">{{ now() }}</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body text-black text-center">
        {{ session('message') }}
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