<!-- Create / Edit Flight Modal -->
<div wire:ignore.self class="modal fade" id="dataModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">
                    {{ $flight_id ? 'Edit Flight' : 'Create New Flight' }}  
                </h5>
                <button wire:click="$refresh" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="airline_id" class="form-label">Airline</label>
                            <select wire:model="airline_id" class="form-select  form-select-sm" id="airline_id">
                                <option value="">Choose an option...</option>
                                @foreach($airlines as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach()
                            </select>
                            @error('airline_id') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="flight_no" class="form-label">Flight Number</label>
                            <input wire:model.blur="flight_no" type="text" class="form-control form-control-sm" id="flight_no">
                            @error('flight_no') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="registration" class="form-label">Registration</label>
                            <select wire:model.blur="registration" class="form-select  form-select-sm" id="registration">
                                <option value="">Choose an option...</option>
                                @foreach($registrations as $value)
                                <option value="{{ $value->registration }}">{{ $value->registration }}</option>
                                @endforeach()
                            </select>
                            @error('registration') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="flight_type" class="form-label">Flight Type</label>
                            <select wire:model.blur="flight_type" class="form-select form-select-sm" id="flight_type">
                                <option value="">Select Flight Type</option>
                                <option value="arrival">Arrival</option>
                                <option value="departure">Departure</option>
                            </select>
                            @error('flight_type') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div> 
                        <div class="col-md-6 mb-3">
                            <label for="origin" class="form-label">Origin</label>
                            <input wire:model.blur="origin" type="text" class="form-control form-control-sm" id="origin">
                            @error('origin') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="destination" class="form-label">Destination</label>
                            <input wire:model.blur="destination" type="text" class="form-control form-control-sm" id="destination">
                            @error('destination') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="scheduled_time_arrival" class="form-label">Scheduled Time of Arrival</label>
                            <input wire:model.blur="scheduled_time_arrival" type="datetime-local" class="form-control form-control-sm" id="scheduled_time_arrival">
                            @error('scheduled_time_arrival') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="scheduled_time_departure" class="form-label">Scheduled Time of Departure</label>
                            <input wire:model.blur="scheduled_time_departure" type="datetime-local" class="form-control form-control-sm" id="scheduled_time_departure">
                            @error('scheduled_time_departure') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-between">
                <button wire:click="$refresh" type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button wire:click.prevent="store" type="button" class="btn btn-sm btn-primary bi bi-check2-circle"> Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Create / Edit Sevices Modal -->
<div wire:ignore.self class="modal fade" id="viewModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="dataModalLabel"> Flight Services </h6>
                <button type="button" class="btn-close" wire:click="$refresh" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body border py-0">
                    @if ($flight_id)
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5> {{ $selectedFlight->flight_no }} - {{ $selectedFlight->registration }}</h5>
                                <span class="text-warning bi bi-arrow-up-right-circle-fill"> </span> {{ $selectedFlight->destination }} {{ date('H:i', strtotime($selectedFlight->scheduled_time_arrival)) }}
                                <span class="text-success bi bi-arrow-down-right-circle-fill"></span> {{ $selectedFlight->origin }} {{ date('H:i', strtotime($selectedFlight->scheduled_time_departure)) }}
                            </div>
                            <div class="text-center">
                                <p> {{ config('app.name', 'Laravel') }} </p>
                                <img src="https://picsum.photos/id/0/100" alt="Logo" style="border-radius: 5px;">
                            </div>
                            <div class="text-end">
                                <h5> Work-Oder No: {{ preg_replace('/\b(\w)\w*\s*/', '$1', ucwords(config('app.name', 'Laravel'))) }}{{ str_pad($selectedFlight->id, 6, '0', STR_PAD_LEFT) }}</h5>
                                <p class="bi bi-calendar-month"> <span> Date: {{ $selectedFlight->created_at->format('d M, Y') }}</span> </p>
                            </div>
                        </div>
                        <hr class="m-2">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th>Start</th>
                                        <th>Finish</th>
                                        <th>Duration</th>
                                        @role('super-admin|admin')
                                        <th>Price</th>
                                        <th></th>
                                        @endrole()
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($selectedFlight->service as $index => $value)
                                        <tr wire:key="{{ $value->id }}">
                                            <td>{{ $index + 1 }}. {{ $value->service->service }}</td>
                                            <td>{{ $value->start }}</td>
                                            <td>{{ $value->finish }}</td>
                                            <td>{{ date('H:i', strtotime($value->finish) - strtotime($value->start)) }}</td>
                                            @role('super-admin|admin')
                                            <td class="text-end">{{ $value->service->price. " $" }}</td>
                                            <td><a href="" wire:click.prevent="destroyService('{{ $value->service_id }}')" class="text-danger bi bi-trash3-fill text-end px-2"></a></td>
                                            @endrole()
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%" class="text-center">No Services for this flight Yet</td>
                                        </tr>
                                    @endforelse
                                    @if(count($selectedFlight->service) > 0)
                                        <tr>
                                            <td colspan="3"><strong>Total Services</strong></td>
                                            <td colspan="1"><strong>{{ count($selectedFlight->service) }} Services</strong></td>
                                            @role('super-admin|admin')
                                            <td colspan="1" class="text-end"><strong>{{ $selectedFlight->service->sum(function ($service) { 
                                                return $service->service->price;
                                               }) }} $</strong></td>
                                            <td></td>
                                            @endrole()
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No Flight Selected</p>
                    @endif
                </div>                
                <div class="card-body border py-1">
                    <div class="form-group col-md-12 my-2">
                        @if(count($ServiceTypes) > 0)
                        <b>Add Services</b>
                        @foreach ($ServiceTypes as $index => $actualService)
                            <div class="d-flex gap-1 mb-1" wire:key="{{ $index }}">
                                <select class="form-select form-select-sm" id="{{ $index }}" wire:model="ServiceTypes.{{ $index }}.service_type">
                                    <option value="">Select a Service...</option>
                                    @foreach($serviceList as $value)
                                    <option value="{{ $value->id }}">{{ $value->service }}</option>
                                    @endforeach()
                                </select>
                                <input class="form-control form-control-sm" type="datetime-local" wire:model="ServiceTypes.{{ $index }}.start">
                                <input class="form-control  form-control-sm" type="datetime-local"wire:model="ServiceTypes.{{ $index }}.finish">
                                <a href="" class="text-danger bi bi-trash3-fill px-2" wire:click.prevent="removeService({{$index}})"></a>
                            </div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div wire:loading wire:target="generatePDF">
                    <div class="custom-spin-overlay">
                        <div class="position-absolute top-50 start-50 translate-middle d-flex justify-content-center">
                            <div class="spinner-border" style="width: 6rem; height: 6rem; border-width: 0.7rem;" role="status">
                                <span class="visually-hidden">Sending Movement ...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border py-2 d-flex align-items-center justify-content-between">
                    <button wire:click.prevent="addService" class="btn btn-sm btn-secondary bi bi-plus-lg"> Add a Service</button>
                    @role('super-admin|admin')
                    <button  wire:loading.attr="disabled" wire:click.prevent="generatePDF" class="btn btn-sm btn-warning bi bi-file-earmark-pdf-fill"> Generate PDF</button>
                    @endrole
                    <button wire:click.prevent="createServices" class="btn btn-sm btn-primary float-end bi bi-check2-circle"> Create Service</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create / Edit Movements Modal -->
<div wire:ignore.self class="modal fade" id="mvtModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="dataModalLabel"> Send Movements </h6>
                <button type="button" wire:click="$refresh" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($flight_id)
                    <div class="card-body border d-flex justify-content-between pt-1">
                        <div>
                            <i class="text-warning bi bi-clock-history"> Last Saved Movement</i>
                            <p>MVT</p>
                            {{ $selectedFlight->flight_no }}/{{ ($selectedFlight->flight_type == 'arrival') ? 
                                date("d", strtotime($selectedFlight->scheduled_time_arrival)) . "." . $selectedFlight->registration . "." . $selectedFlight->destination : 
                                date("d", strtotime($selectedFlight->scheduled_time_departure)) . "." . $selectedFlight->registration . "." . $selectedFlight->origin }}</p>
                            @if ($selectedFlight->flight_type == 'arrival')
                            <p>AA{{ date("Hi", strtotime($flightMvt->touchdown ?? null)) }}/{{ date("Hi", strtotime($flightMvt->onblocks  ?? null)) }}</p>
                            @else
                            <p>AD{{ date("Hi", strtotime($flightMvt->offblocks ?? null)) }}/{{ date("Hi", strtotime($flightMvt->airborne ?? null)) }}
                            EA{{ date("Hi", strtotime($flightMvt->airborne ?? null)+strtotime($flightMvt->flight_time ?? null)) }} {{ $selectedFlight->destination }}</p>
                            @if (empty($outputdelay))  @else {{ "DL" .$outputdelay ?? null }} @endif
                            <p>PX{{ $flightMvt->passengers ?? null }}</p>
                            @if (empty($outputedelay))  @else {{ "EDL" .$outputedelay ?? null }}</p> @endif
                            @if (empty($outputdelay))  @else {{ "DLA" .$outputdla ?? null }}</p> @endif
                            @if (empty($outputdescription))  @else {!! "SI ". nl2br(e($outputdescription)) ?? null !!} @endif
                            <p>@if (empty($flightMvt->remarks))  @else SI {{ strtoupper($flightMvt->remarks ?? null) }} @endif</p>
                            <p>SI EET {{ date("Hi", strtotime($flightMvt->flight_time ?? 0)) }} HRS</p>
                            @endif
                        </div>
                        <div class="small">
                            <i class="text-primary me-4 bi bi-clock-history"> History <small>(Last 2 Movements)</small></i>
                            <input name="history" wire:click="$toggle('history')" class="form-check-input mt-0 ms-2" type="checkbox">
                            @if($history)
                            @forelse($selectedFlight->movement->take(2) as $movement)
                            <div class="row border">
                                <div class="col-md px-2 border small">
                                    <b class="small"><u>Sent: {{ date("d-M-Y H:i:s", strtotime($movement->created_at)) }}</u></b>
                                    <p>MVT</p>
                                    {{ $selectedFlight->flight_no }}/{{ ($selectedFlight->flight_type == 'arrival') ? 
                                    date("d", strtotime($selectedFlight->scheduled_time_arrival)) . "." . $selectedFlight->registration . "." . $selectedFlight->destination : 
                                    date("d", strtotime($selectedFlight->scheduled_time_departure)) . "." . $selectedFlight->registration . "." . $selectedFlight->origin }}</p>
                                    @if ($selectedFlight->flight_type == 'arrival')
                                    <p>AA{{ date("Hi", strtotime($movement->touchdown)) }}/{{ date("Hi", strtotime($movement->onblocks)) }}</p>
                                    @else
                                    <p>AD{{ date("Hi", strtotime($movement->offblocks)) }}/{{ date("Hi", strtotime($movement->airborne)) }}
                                        EA{{ date("Hi", strtotime($movement->airborne)+strtotime($movement->flight_time)) }} {{ $selectedFlight->destination }}</p>
                                        @if (empty($outputdelay))  @else {{ "DL" .$outputdelay ?? null }} @endif
                                        <p>PX{{ $movement->passengers ?? null }}</p>
                                        <p>@if (empty($outputedelay))  @else {{ "EDL" .$outputedelay ?? null }} @endif</p>
                                        <p>@if (empty($outputdelay))  @else {{ "DLA" .$outputdla ?? null }} @endif</p>
                                        @if (empty($outputdescription))  @else {!! "SI ". nl2br(e($outputdescription)) ?? null !!} @endif
                                        <p>@if (empty($flightMvt->remarks))  @else SI {{ strtoupper($movement->remarks ?? null) }} @endif</p>
                                        <p>SI EET {{ date("Hi", strtotime($movement->flight_time ?? 0)) }} HRS</p>
                                    @endif
                                </div>
                            </div>
                                @empty
                                    <p class="text-center">No Movements Sent for this flight </p>
                                @endforelse
                            @endif
                        </div>
                    </div>
                    <div class="card-body border">
                        <form>
                            <div class="row">
                                <input type="hidden" wire:model="flight_id">
                                @if ($selectedFlight->flight_type == 'arrival')
                                <div class="form-group col-md-4">
                                    <label for="touchdown">Touchdown</label>
                                    <input type="datetime-local" class="form-control" id="touchdown" wire:model="touchdown">
                                    @error('touchdown') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="onblocks">On Blocks</label>
                                    <input type="datetime-local" class="form-control" id="onblocks" wire:model="onblocks">
                                    @error('onblocks') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                @else
                                <div class="form-group col-md-4">
                                    <label for="offblocks">Off Blocks</label>
                                    <input type="datetime-local" class="form-control" id="offblocks" wire:model="offblocks">
                                    @error('offblocks') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="airborne">Airborne</label>
                                    <input type="datetime-local" class="form-control" id="airborne" wire:model="airborne">
                                    @error('airborne') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="passengers">Passengers</label>
                                    <input type="number" class="form-control" id="passengers" wire:model="passengers">
                                    @error('passengers') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="remarks">Remarks</label>
                                    <textarea class="form-control" id="remarks" wire:model.blur="remarks"></textarea>
                                    @error('remarks') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                @endif
                            </div>

                            @if ($selectedFlight->flight_type == 'departure')
                                <div class="form-group col-md-12 my-2">
                                    <p>Delay Codes</p>
                                    @foreach ($delayCodes as $index => $delayCode)
                                        <div class="d-flex gap-1 mb-1">
                                            <select wire:model="delayCodes.{{ $index }}.code" class="form-select  form-select-sm">
                                                <option value="">Choose an option...</option>
                                                @foreach($airlineDelays as $value)
                                                    <option value="{{ $value->alpha_numeric_code }}"> {{ $value->alpha_numeric_code }} - {{ Str::limit($value->description, 50) }} </option>
                                                @endforeach
                                            </select>
                                            <input maxlength="5" class="form-control form-control-sm" type="text" wire:model="delayCodes.{{ $index }}.duration" placeholder="0000">
                                            <input class="form-control form-control-sm" type="text" wire:model="delayCodes.{{ $index }}.description" placeholder="Decription">
                                            <a href="" class="bi bi-trash3-fill text-danger text-center px-4" wire:click.prevent="removeDelay({{ $index }})"></a>
                                        </div>
                                        @error('delayCodes.'.$index.'.duration') <span class="text-danger small">{{ $message }}</span> @enderror
                                    @endforeach
                                    @if (count($delayCodes) < 4 )
                                        <button class="btn custom-btn-sm btn-secondary bi bi-plus-circle" type="button" wire:click.prevent="addDelay"> Add Delay</button>
                                    @endif
                                </div>
                            @endif
                        </form>
                    </div>
                    @else
                        <p>Loading Flight...</p>
                    @endif
                <div wire:loading wire:target="sendMovement, saveMovement">
                    <div class="custom-spin-overlay">
                        <div class="position-absolute top-50 start-50 translate-middle d-flex justify-content-center">
                            <div class="spinner-border" style="width: 6rem; height: 6rem; border-width: 0.7rem;" role="status">
                                <span class="visually-hidden">Sending Movement ...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body border py-2 d-flex align-items-center justify-content-between">
                    <button wire:click="$refresh" data-bs-dismiss="modal" type="button" class="btn btn-sm btn-secondary bi bi-backspace-fill"> Close</button>
                    <button wire:loading.attr="disabled" wire:click.prevent="sendMovement" type="button" class="btn btn-sm btn-success bi bi-envelope-check-fill"> Send Movement</button>
                    <button wire:loading.attr="disabled" wire:click.prevent="saveMovement" type="button" class="btn btn-sm btn-primary bi bi-clock-history"> Save Movement</button>
                </div>
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