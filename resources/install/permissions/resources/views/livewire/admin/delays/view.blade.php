@section('title', __('Delays'))
<div class="row justify-content-center">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div style="display: flex; justify-content: space-between; align-items: center;">
					<div class="float-left">
						<h5>Delay Codes </h5>
					</div>
					<div>
						<select wire:model.live="keyWord" class="form-select  form-select-sm" id="airline_id">
							<option value="">Filter By Airline...</option>
							@foreach($airlines as $value)
							<option value="{{ $value->id }}">{{ $value->name }}</option>
							@endforeach()
						</select>
					</div>
					<div class="d-flex gap-4">
						<form wire:submit="importDelays" enctype="multipart/form-data">
							<div class="d-flex gap-4">
								<input type="file" accept=".csv, .xlsx" class="form-control form-control-sm mr-2" id="file" wire:model.live="file">
								@error('file') <span class="text-danger small">{{ $message }}</span> @enderror
								<button type="submit" class="btn btn-success btn-sm bi bi-cloud-upload-fill"></button>
							</div>
						</form>
						<button wire:click="downloadDelays" class="btn btn-warning btn-sm bi bi-cloud-download-fill"> Download Sample</button>
					</div>
					<div class="btn btn-sm btn-info bi bi-plus-lg" data-bs-toggle="modal" data-bs-target="#dataModal">
							Add Delay Code
					</div>
				</div>
			</div>
			<div class="card-body">
				@include('livewire.delays.modals')
			<div class="table-responsive">
				<table class="table table-bordered table-sm">
					<thead class="thead">
						<tr> 
							<td>#</td> 
							<th>Numeric Code</th>
							<th>Alpha Code</th>
							<th>Description</th>
							<th>Accountable</th>
							<th>Airline</th>
							<td>ACTIONS</td>
						</tr>
					</thead>
					<tbody>
						@forelse($delays as $row)
						<tr wire:key="{{ $row->id }}">
							<td>{{ $loop->iteration }}</td> 
							<td>{{ $row->numeric_code }}</td>
							<td>{{ $row->alpha_numeric_code }}</td>
							<td>{{ $row->description }}</td>
							<td>{{ $row->accountable }}</td>
							<td>{{ $row->airline->name }}</td>
							<td width="90">
								<div class="dropdown">
									<a class="btn custom-btn-sm btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										Actions
									</a>
									<ul class="dropdown-menu">
										<li><a href="" data-bs-toggle="modal" data-bs-target="#dataModal" class="dropdown-item bi bi-pencil-square" wire:click.prevent="edit({{$row->id}})"> Edit </a></li>
										<li><a href="" class="dropdown-item bi bi-trash3" onclick="confirm('Confirm Delete Flight id {{$row->id}}? \nDeleted Flight cannot be recovered!')||event.stopImmediatePropagation()" wire:click.prevent="destroy({{$row->id}})"> Delete </a></li>  
									</ul>
								</div>
							</td>
						</tr>
						@empty
						<tr>
							<td class="text-center" colspan="100%">No Delays Found </td>
						</tr>
						@endforelse
					</tbody>
				</table>
				<div class="float-end">{{ $delays->links() }}</div>
				</div>
			</div>
		</div>
	</div>
</div>