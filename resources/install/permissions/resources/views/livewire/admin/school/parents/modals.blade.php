<div wire:ignore.self class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">
                    Create New Parent
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label for="name">Parent Name</label>
                            <input type="text" id="name" class="form-control" wire:model.blur="name" autocomplete="off">
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="email">Parent Email</label>
                            <input type="email" id="email" class="form-control" wire:model.blur="email" autocomplete="off">
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="phone">Phone Number</label>
                            <input type="number" class="form-control" id="phone" wire:model.blur="phone">
                            @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button wire:click.prevent="save" type="button" class="btn btn-sm btn-primary bi bi-check2-circle"> Save</button>
            </div>
        </div>
    </div>
</div>