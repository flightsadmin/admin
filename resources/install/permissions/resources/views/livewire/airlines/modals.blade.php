<!-- Create / Edit Airlines Modal -->
<div wire:ignore.self class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">
                    Create New Airline
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label for="name">Airline Name</label>
                            <input type="text" id="name" class="form-control" wire:model.blur="name" autocomplete="off">
                            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="iata_code">Airline Code</label>
                            <input type="text"  id="iata_code" maxlength="2" class="form-control" wire:model.blur="iata_code">
                            @error('iata_code') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="base">Airline Base</label>
                            <input type="text" id="base" class="form-control" wire:model.blur="base">
                            @error('base') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-md-6 mb-2">
                            <label for="base_iata_code">Airline Base Iata Code</label>
                            <input type="text" class="form-control" id="base_iata_code" wire:model.blur="base_iata_code">
                            @error('base_iata_code') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button wire:click.prevent="saveAirline" type="button" class="btn btn-sm btn-primary bi bi-check2-circle"> Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Create / Edit Routes Modal -->
<div wire:ignore.self class="modal fade" id="routeModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">
                    Airline Routes
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <form>
                        <div class="row">
                            <input type="hidden" wire:model="airline_id">
                            <div class="col-md-6 mb-3">
                                <label for="origin">Origin:</label>
                                <input type="text" maxlength="4" id="origin" class="form-control" wire:model.blur="origin">
                                @error('origin') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="destination">Destination:</label>
                                <input type="text" id="destination" maxlength="34" class="form-control" wire:model.blur="destination">
                                @error('destination') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="flight_time">Flight Time:</label>
                                <input type="text" id="flight_time" maxlength="4" class="form-control form-control-sm" wire:model.blur="flight_time" placeholder="0000">
                                @error('flight_time') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="emails">Emails:</label>
                                <div class="d-flex gap-4">
                                    <input type="text" id="emails" class="form-control form-control-sm" wire:model.blur="email" placeholder="example test@test.com">
                                    <a href="" wire:click.prevent="addEmail('{{ $email }}')" class="text-danger h5 bi bi-envelope-plus-fill"></a>
                                </div>
                                <ol class="mt-2">
                                    @foreach ($emails as $email)
                                        <li>{{ $email }} <a href="" wire:click.prevent="removeEmail('{{ $email }}')" class="bi bi-trash"></a></li>
                                    @endforeach
                                </ol>
                                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-primary bi bi-check2-circle" wire:click.prevent="saveRoute"> Save</span>
                </button>
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