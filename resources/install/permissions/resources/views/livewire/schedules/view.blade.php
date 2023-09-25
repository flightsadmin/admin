<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <h5>Flight Schedules </h5>
                        </div>
                        <div class="d-flex gap-4">
                            <form wire:submit="import" enctype="multipart/form-data">
                                <div class="d-flex gap-4">
                                    <input type="file" accept=".csv, .xlsx" class="form-control form-control-sm mr-2" id="file" wire:model.live="file">
                                    @error('file') <span class="text-danger small">{{ $message }}</span> @enderror
                                    <button type="submit" class="btn btn-success btn-sm bi bi-cloud-upload-fill"></button>
                                </div>
                            </form>
                            <button wire:click="downloadSample" class="btn btn-warning btn-sm bi bi-cloud-download-fill"> Download Sample</button>
                        </div>
                        <div class="row float-end">
                            <div class="col-md">
                                <label for="start_date">Start Date:</label>
                                <input type="date" wire:model="startDate" id="start_date" min="{{ date('Y-m-d', strtotime('-1 days')) }}" class="form-control form-control-sm">
                            </div>
                            <div class="col-md">
                                <label for="end_date">End Date:</label>
                                <input type="date" wire:model="endDate" id="end_date" min="{{ date('Y-m-d', strtotime('+2 days')) }}" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body border">
                @if($flightNumbers)
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th width="150">Airline</th>
                                    <th width="130">Flight Number</th>
                                    <th width="230">Timings (Arrival & Departure)</th>
                                    <th width="130">Origin</th>
                                    <th width="130">Destination</th>
                                    <th width="150">Type</th>
                                    @foreach ($days as $day)
                                    <th>{{ $day }}</th>
                                    @endforeach
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($flightNumbers as $index => $flightNumber)
                                <tr wire:key="{{ $index }}">
                                    <td>
                                        <select wire:model="flightFields.{{ $flightNumber }}.airline_id" class="form-select  form-select-sm">
                                            <option value="">--Select Airline--</option>
                                            @foreach($airlines as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach()
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" size="8" wire:model="flightFields.{{ $flightNumber }}.flight_no">
                                    </td>
                                    <td>
                                        <input type="time" wire:model="flightFields.{{ $flightNumber }}.arrival">
                                        <input type="time" wire:model="flightFields.{{ $flightNumber }}.departure">
                                    </td>
                                    <td>
                                        <input type="text" size="8" wire:model="flightFields.{{ $flightNumber }}.origin">
                                    </td>
                                    <td>
                                        <input type="text" size="8" wire:model="flightFields.{{ $flightNumber }}.destination">
                                    </td>
                                    <td>
                                        <select wire:model="flightFields.{{ $flightNumber }}.flight_type" class="form-select  form-select-sm">
                                            <option value="">--Select Type--</option>
                                            <option value="arrival">Arrival</option>
                                            <option value="departure">Departure</option>                                            
                                        </select>
                                    </td>
                                    @foreach ($days as $day)
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" wire:model="selectedDays" value="{{ $flightNumber }}-{{ $day }}" class="form-check-input">
                                        </div>
                                    </td>
                                    @endforeach
                                    <td>
                                        <a href="" wire:click.prevent="removeFlights({{$index}})" class="text-danger bi bi-trash3"></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                    <button wire:click.prevent="addFlights" class="btn btn-sm btn-secondary">+ Add a Schedule</button>
                    <button wire:click="createFlights" class="btn btn-sm btn-primary float-end">Create Flights</button>
                </div>
                <hr>
                <div class="card-body border">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="thead">
                                <tr> 
                                    <td>#</td>
                                    <td><a href="" wire:click.prevent="deleteSelected" class="text-danger bi bi-trash3-fill"></a></td>
                                    <th>Flight No</th>
                                    <th>Registration</th>
                                    <th>STA</th>
                                    <th>STD</th>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($flights as $row)
                                <tr wire:key="{{ $row->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td><input type="checkbox" wire:model="selectedFlights" value="{{ $row->flight_no }}"></td>
                                    <td>{{ $row->flight_no }}</td>
                                    <td>{{ $row->registration }}</td>
                                    <td>{{ $row->scheduled_time_arrival }}</td>
                                    <td>{{ $row->scheduled_time_departure }}</td>
                                    <td>{{ $row->origin }}</td>
                                    <td>{{ $row->destination }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="100%">No Flights Found </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="float-end">{{ $flights->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>