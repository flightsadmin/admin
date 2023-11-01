<div wire:ignore.self class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">
                    Create New Teacher
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label for="name">Teachers Name</label>
                            <input type="text" id="name" class="form-control form-control-sm" wire:model.blur="name" autocomplete="off">
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="email">Teachers Email</label>
                            <input type="text" id="email" class="form-control form-control-sm" wire:model.blur="email" autocomplete="off">
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="date_of_birth">Date of Birth</label>
                            <input type="date" id="date_of_birth" class="form-control form-control-sm" wire:model.blur="date_of_birth"
                                autocomplete="off">
                            @error('date_of_birth')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" id="username" wire:model.blur="username" disabled placeholder="Staff Number">
                                @if (!$username)
                                    <span type="button" class="btn btn-sm btn-secondary bi-check-circle" wire:click.prevent="generateUserName"> Generate</span>
                                @endif
                            </div>
                            @error('username')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="guardian_id">Subjects:</label>
                            @foreach ($lessons as $row)
                                <div wire:key="{{ 'row_' . $row->id }}" class="col-md-4 bordered">
                                    <input class="form-check-input me-2" type="checkbox"
                                        wire:model="subjects"
                                        value="{{ $row->id }}"
                                        id="row_{{ $row->id }}">
                                    <label class="form-check-label" for="row_{{ $row->id }}">
                                        <strong>{{ $row->name }}</strong>
                                    </label>
                                </div>
                            @endforeach
                            @error('guardian_id')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="grade_id" class="form-label">Classes:</label>
                            @foreach ($classes as $row)
                                <div wire:key="{{ 'row' . $row->id }}" class="col-md-4 bordered">
                                    <input class="form-check-input me-2" type="checkbox"
                                        wire:model="grades"
                                        value="{{ $row->id }}"
                                        id="row{{ $row->id }}">
                                    <label class="form-check-label" for="grade_{{ $row->id }}">
                                        <strong>{{ $row->name }}</strong>
                                    </label>
                                </div>
                            @endforeach
                            @error('grades_selection')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select form-select-sm" id="gender" wire:model="gender">
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
                            <label class="form-label" for="phone">Phone</label>
                            <input type="text" id="phone" class="form-control form-control-sm" wire:model.blur="phone"
                                autocomplete="off">
                            @error('phone')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 mb-2">
                            <label for="address">Address</label>
                            <textarea class="form-control form-control-sm" id="address" wire:model.blur="address"></textarea>
                            @error('address')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button wire:click.prevent="save" type="button" class="btn btn-sm btn-primary bi-check2-circle"> Save</button>
            </div>
        </div>
    </div>
</div>
