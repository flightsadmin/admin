@section('title', __('Schedules'))
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h5>Class Schedule</h5>
                    </div>
                    <div class="row float-end">
                        <div class="col-md">
                            <label for="start_date">Start Date:</label>
                            <input type="date" wire:model="startDate" id="start_date" min="{{ date('Y-m-d', strtotime('-1 days')) }}"
                                class="form-control form-control-sm">
                        </div>
                        <div class="col-md">
                            <label for="end_date">End Date:</label>
                            <input type="date" wire:model="endDate" id="end_date" min="{{ date('Y-m-d', strtotime('+2 days')) }}"
                                class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body border">
                @if ($flightNumbers)
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th width="150">Class</th>
                                    <th width="130">Subject</th>
                                    <th width="130">Start</th>
                                    <th width="130">End</th>
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
                                            <select wire:model="flightFields.{{ $flightNumber }}.grade_id"
                                                class="form-select  form-select-sm">
                                                <option value="">--Select Class--</option>
                                                @foreach ($classes as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach()
                                            </select>
                                        </td>
                                        <td>
                                            <select wire:model="flightFields.{{ $flightNumber }}.subject"
                                                class="form-select  form-select-sm">
                                                <option value="">--Select Subject--</option>
                                                @foreach ($subjects as $value)
                                                    <option value="{{ $value->name }}">{{ $value->name }}</option>
                                                @endforeach()
                                            </select>
                                        </td>
                                        <td>
                                            <input type="time" wire:model="flightFields.{{ $flightNumber }}.start">
                                        </td>
                                        <td>
                                            <input type="time" wire:model="flightFields.{{ $flightNumber }}.end">
                                        </td>
                                        @foreach ($days as $day)
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" wire:model="selectedDays"
                                                        value="{{ $flightNumber }}-{{ $day }}" class="form-check-input">
                                                </div>
                                            </td>
                                        @endforeach
                                        <td>
                                            <a href="" wire:click.prevent="removeFlights({{ $index }})"
                                                class="text-danger bi bi-trash3"></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <button wire:click="addFlights" class="btn btn-sm btn-secondary">+ Add a Schedule</button>
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
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Start</th>
                                <th>End</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($timetables as $row)
                                <tr wire:key="{{ $row->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td><input type="checkbox" wire:model="selectedFlights" value="{{ $row->id }}"></td>
                                    <td>{{ $row->grade->name }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->start_time }}</td>
                                    <td>{{ $row->end_time }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">No Timetable Found </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="float-end">{{ $timetables->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
