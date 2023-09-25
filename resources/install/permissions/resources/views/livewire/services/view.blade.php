<div>
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<div style="display: flex; justify-content: space-between; align-items: center;">
						<div class="float-left">
							<h5>Services </h5>
						</div>
						<div>
							<input wire:model.live.debounce.500ms="keyWord" type="text" class="form-control form-control-sm" name="search" id="search" placeholder="Search Service">
						</div>
						<div class="btn btn-sm btn-info bi bi-plus-lg" data-bs-toggle="modal" data-bs-target="#dataModal">
							 Add Service
						</div>
					</div>
				</div>
				<div class="card-body">
					@include('livewire.services.modals')
					<div class="row">
						@forelse($services as $row)
						<div class="col-md-4 border d-flex justify-content-between" wire:key="{{ $row->id }}">
							<div class="p-2">
								<b><i class="bi bi-building-check text-success"></i> {{ $row->service }}</b>
								<p> <i class="bi bi-cash-coin text-info"> </i> $ {{ number_format($row->price, 2) }}</p>
							</div>
							<div>
								<div class="dropdown p-2">
									<a class="btn custom-btn-sm text-white btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										Actions
									</a>
									<ul class="dropdown-menu">
										<li><a data-bs-toggle="modal" data-bs-target="#dataModal" class="dropdown-item bi bi-pencil-square" wire:click="edit({{$row->id}})"> Edit </a></li>
										<li><a class="dropdown-item bi bi-trash3" onclick="confirm('Confirm Delete Service id {{$row->id}}? \nDeleted Service cannot be recovered!')||event.stopImmediatePropagation()" wire:click="destroy({{$row->id}})"> Delete </a></li>  
									</ul>
								</div>
							</div>
						</div>
						@empty
						<div class="col-md-12">
							<p class="text-center">No Services Created Yet</p>
						</div>
						@endforelse
					</div>
					<div class="float-end mt-2 mb-0">{{ $services->links() }}</div>
				</div>
			</div>
		</div>
	</div>
</div>