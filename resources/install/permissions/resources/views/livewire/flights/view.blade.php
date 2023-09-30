@section('title', __('Flights'))
<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div style="display: flex; justify-content: space-between; align-items: center;">
					<div class="float-left">
						<h5>Flights</h5>
					</div>
					<div>
						<input wire:model.live.debounce.500ms="keyWord" type="text" class="form-control form-control-sm" name="search" id="search" placeholder="Search Flights">
					</div>
					<div>
						<input type="date" wire:model.live="selectedDate" id="datepicker" class="form-control form-control-sm">
					</div>
					<div class="d-flex gap-4">
						@role('super-admin|admin')
							<a href="{{ route('admin.schedules') }}" class="btn btn-sm btn-warning bi bi-newspaper"> Generate Schedule </a>
						@endrole
						<div class="btn btn-sm btn-info bi bi-plus-lg" data-bs-toggle="modal" data-bs-target="#dataModal">
								Add Flight
						</div>
					</div>
				</div>
			</div>
			<div class="card-body">
				@include('livewire.flights.modals')
			<div class="table-responsive">
				<table class="table table-bordered table-sm">
					<thead class="thead">
						<tr> 
							<td>#</td>
							<td></td>
							<th>Flight No</th>
							<th>Registration</th>
							<th>STA</th>
							<th>STD</th>
							<th>Origin</th>
							<th>Destination</th>
							<td>ACTIONS</td>
						</tr>
					</thead>
					<tbody>
						@forelse($flights as $row)
						<tr wire:key="{{ $row->id }}">
							<td>{{ $loop->iteration }}</td>
							<td class="text-center px-0"><span class="{{ ($row->flight_type == 'arrival') ? 'text-secondary h5 bi bi-arrow-down-right-circle-fill' : 'text-info h5 bi bi-arrow-up-right-circle-fill'}}"></span></td>
							<td>{{ $row->flight_no }}</td>
							<td>{{ $row->registration }}</td>
							<td>{{ $row->scheduled_time_arrival }}</td>
							<td>{{ $row->scheduled_time_departure }}</td>
							<td>{{ $row->origin }}</td>
							<td>{{ $row->destination }}</td>
							<td width="90">
							<div class="dropdown">
									<a class="btn custom-btn-sm btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										Actions
									</a>
									<ul class="dropdown-menu">
										<li><a href="" data-bs-toggle="modal" data-bs-target="#viewModal" class="dropdown-item bi bi-database-add" wire:click.prevent="viewFlight({{ $row->id }})" > Services </a></li>
										<li><a href="" data-bs-toggle="modal" data-bs-target="#mvtModal" class="dropdown-item bi bi-watch" wire:click.prevent="viewFlight({{ $row->id }})" > Movements </a></li>
										<li><a href="" data-bs-toggle="modal" data-bs-target="#dataModal" class="dropdown-item bi bi-pencil-square" wire:click.prevent="edit({{$row->id}})"> Edit </a></li>
										<li><a href="" class="dropdown-item bi bi-trash3" onclick="confirm('Confirm Delete Flight {{$row->flight_no}}? \nDeleted Flight cannot be recovered!')||event.stopImmediatePropagation()" wire:click.prevent="destroy({{$row->id}})"> Delete </a></li>  
									</ul>
								</div>
							</td>
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