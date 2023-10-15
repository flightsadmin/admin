<div wire:ignore.self class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">
                    Create New Student
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label for="name">Students Name</label>
                            <input type="text" id="name" class="form-control" wire:model.blur="name" autocomplete="off">
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="date_of_birth">Students Name</label>
                            <input type="date" id="date_of_birth" class="form-control" wire:model.blur="date_of_birth"
                                autocomplete="off">
                            @error('date_of_birth')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="guardian_id">Parent Name</label>
                            <select class="form-select" id="guardian_id" wire:model.blur="guardian_id">
                                <option value="">Select Parent</option>
                                @foreach ($parents as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                                @endforeach
                            </select>
                            @error('guardian_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="grade_id" class="form-label">Class</label>
                            <select class="form-select" id="grade_id" wire:model="grade_id">
                                <option value="">Select Class</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                            @error('grade_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" wire:model="gender">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                            @error('gender')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="roll_number">Roll Number</label>
                            <input type="text" class="form-control" id="roll_number" wire:model.blur="roll_number">
                            @error('roll_number')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 mb-2">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" wire:model.blur="address"></textarea>
                            @error('address')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button wire:click.prevent="saveStudent" type="button" class="btn btn-sm btn-primary bi bi-check2-circle"> Save</button>
            </div>
        </div>
    </div>
</div>
<!-- Success Message Toast  -->
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="myToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header text-bg-success">
            <i class="me-2 bi bi-send-fill"></i>
            <strong class="me-auto text-black">Success</strong>
            <small class="text-white">{{ now() }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body text-black text-center">
            <div class="p-4">
                {{ session('message') }}
            </div>
        </div>
    </div>
</div>