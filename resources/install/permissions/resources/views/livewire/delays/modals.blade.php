<!-- Create / Edit Airlines Modal -->
<div wire:ignore.self class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">
                    Create Delay Code
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label for="airline_id" class="form-label">Airline</label>
                            <select wire:model="airline_id" class="form-select  form-select-sm" id="airline_id">
                                <option value="">Choose an option...</option>
                                @foreach($airlines as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach()
                            </select>
                            @error('airline_id') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="numeric_code" class="form-label">Numeric Code</label>
                            <input type="text" maxlength="2" class="form-control form-control-sm" id="numeric_code" wire:model.blur="numeric_code">
                            @error('numeric_code') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="alpha_numeric_code" class="form-label">Alpha Numeric</label>
                            <input type="text" class="form-control form-control-sm" id="alpha_numeric_code" wire:model.blur="alpha_numeric_code">
                            @error('alpha_numeric_code') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control form-control-sm" id="description" wire:model.blur="description">
                            @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="accountable" class="form-label">Accountable</label>
                            <select wire:model="accountable" class="form-select  form-select-sm" id="accountable">
                                <option value="">Choose an option...</option>
                                <option value="Ground Handling">Ground Handling</option>
                                <option value="Airline">Airline</option>
                                <option value="Airport">Airport</option>
                                <option value="Immigration">Immigration</option>
                                <option value="Customs">Customs</option>
                                <option value="Police">Police</option>
                            </select>
                            @error('accountable') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button wire:click.prevent="saveDelay" type="button" class="btn btn-sm btn-primary bi bi-check2-circle"> Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Message Toast  -->
<div  id="statusToast" class="toast position-fixed top-0 end-0 p-3 text-bg-success" style="margin-top:5px; margin-bottom:0px;" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header text-bg-success">
    <i class="me-2 bi bi-send-fill"></i>
    <strong class="me-auto text-black">Success</strong>
    <small class="text-white">{{ now() }}</small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body text-black text-center">
    {{ session('message') }}
  </div>
</div>