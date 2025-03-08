@section('title', __('Registration'))
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="float-left">
                        <h5>Registrations </h5>
                    </div>
                    <div>
                        <input wire:model.live.debounce.500ms="keyWord" type="text" class="form-control form-control-sm" name="search"
                            id="search" placeholder="Search Registration">
                    </div>
                    <div class="d-flex gap-4">
                        <form wire:submit="importRegistration" enctype="multipart/form-data">
                            <div class="d-flex gap-4">
                                <input type="file" accept=".csv, .xlsx" class="form-control form-control-sm mr-2" id="file"
                                    wire:model.live="file">
                                @error('file')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                                <button type="submit" class="btn btn-success btn-sm bi-cloud-upload-fill"></button>
                            </div>
                        </form>
                        <button wire:click="registrationSample" class="btn btn-warning btn-sm bi-cloud-download-fill"> Download
                            Sample</button>
                    </div>
                    <div class="btn btn-sm btn-info bi-plus-lg" data-bs-toggle="modal" data-bs-target="#dataModal">
                        Add Registration
                    </div>
                </div>
            </div>

            <div class="card-body">
                @include('livewire.flight.registrations.modals')
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="thead">
                            <tr>
                                <td>#</td>
                                <th>Registration</th>
                                <th>Aircraft Type</th>
                                <th>Airline Name</th>
                                <th>Iata Code</th>
                                <th>Airline Base</th>
                                <td>ACTIONS</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $row)
                                <tr wire:key="{{ $row->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->registration }}</td>
                                    <td>{{ $row->aircraft_type }}</td>
                                    <td>{{ $row->airline->name }}</td>
                                    <td>{{ $row->airline->iata_code }}</td>
                                    <td>{{ $row->airline->base }}</td>
                                    <td width="90">
                                        <div class="dropdown">
                                            <a class="btn custom-btn-sm btn-secondary dropdown-toggle" href="#" role="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a data-bs-toggle="modal" data-bs-target="#dataModal"
                                                        class="dropdown-item bi-pencil-square" wire:click="edit({{ $row->id }})"> Edit
                                                    </a></li>
                                                <li><a class="dropdown-item bi-trash3"
                                                        onclick="confirm('Confirm Delete Registration id {{ $row->id }}? \nDeleted Registration cannot be recovered!')||event.stopImmediatePropagation()"
                                                        wire:click="destroy({{ $row->id }})"> Delete </a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">No Registrations Found </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="float-end">{{ $registrations->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
