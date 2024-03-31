@section('title', __('Rosters'))
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h5>Shift Roster </h5>
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

            <div class="card-body">
                @if ($staffRosters)
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th width="180">Staff Name</th>
                                    <th width="130">Shift Start</th>
                                    <th width="130">Required Hours</th>
                                    @foreach ($days as $day)
                                        <th>{{ $day }}</th>
                                    @endforeach
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($staffRosters as $index => $roster)
                                    <tr wire:key="{{ $index }}">
                                        <td>
                                            <select wire:model="rosterFields.{{ $roster }}.employee_id"
                                                class="form-select  form-select-sm">
                                                <option value="">--Select User--</option>
                                                @foreach ($employees as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                @endforeach()
                                            </select>
                                        </td>
                                        <td>
                                            <select wire:model="rosterFields.{{ $roster }}.shift_start"
                                                class="form-select form-select-sm">
                                                <option value="">--Select Type--</option>
                                                @for ($hour = 0; $hour < 24; $hour++)
                                                    @php
                                                        $time = sprintf('%02d', $hour) . ':00:00';
                                                        $displayTime = date('h:i A', strtotime($time));
                                                    @endphp
                                                    <option value="{{ $time }}">{{ $displayTime }}</option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td>
                                            <select wire:model="rosterFields.{{ $roster }}.shift_hours"
                                                class="form-select  form-select-sm">
                                                <option value="">--Select Type--</option>
                                                <option value="8">8 Hours</option>
                                                <option value="9">9 Hours</option>
                                                <option value="10">10 Hours</option>
                                                <option value="11">11 Hours</option>
                                                <option value="12">12 Hours</option>
                                            </select>
                                        </td>
                                        @foreach ($days as $day)
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" wire:model="selectedDays"
                                                        value="{{ $roster }}-{{ $day }}" class="form-check-input">
                                                </div>
                                            </td>
                                        @endforeach
                                        <td>
                                            <a href="" wire:click.prevent="removeRosters({{ $index }})"
                                                class="text-danger bi-trash3"></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <button wire:click="addRosters" class="btn btn-sm btn-secondary">+ Add a Roster</button>
                <button wire:click="createRosters" class="btn btn-sm btn-primary float-end">Create Roster</button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User</th>
                                @foreach ($dates as $date)
                                    <th>{{ date("D d-M", strtotime($date)) }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    @foreach ($dates as $date)
                                        <td class="text-center">
                                            @foreach ($rosters[$date] as $r)
                                                @if ($r->user_id == $user->id)
                                                    {{ $r->shift_start ? $r->shift_start->format('Hi') : '' }}-{{ $r->shift_end ? $r->shift_end->format('Hi') : '' }}
                                                @endif
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
