<!-- Create / Edit Registration Modal -->
<div wire:ignore.self class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">
                    {{ $registration_id ? 'Edit Registration' : 'Create New Registration' }}  
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="registration" class="form-label">Registration</label>
                        <input wire:model.blur="registration" type="text" class="form-control" id="registration">
                        @error('registration') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="aircraft_type" class="form-label">Aircraft Type</label>
                        <select wire:model.blur="aircraft_type" class="form-select" id="aircraft_type">
                            <option value="">Select Aircraft Type</option>
                            @foreach($registrations->pluck('aircraft_type')->unique()->sort() as $value)
                                <option value="{{  $value }}">{{  $value }}</option>
                            @endforeach
                        </select>
                        @error('aircraft_type') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="airline_id">Airline:</label>
                        <select class="form-select" id="airline_id" wire:model.blur="airline_id">
                            <option value="">Select an airline</option>
                            @foreach($registrations->pluck('airline')->unique()->sortBy('name') as $airline)
                                <option value="{{ $airline['id'] }}">{{ $airline['name'] }}</option>
                            @endforeach
                        </select>
                        @error('airline_id') <span class="text-danger small">{{ $message }}</span>@enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button wire:click.prevent="store" type="button" class="btn btn-sm btn-primary bi-check2-circle"> Save</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script type="module">
        const genModal = new bootstrap.Modal('#dataModal');
        window.addEventListener('closeModal', () => {
            genModal.hide();
        });
    </script>
@endpush