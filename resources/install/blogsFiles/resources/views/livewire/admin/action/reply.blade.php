<div>
    <form wire:submit.prevent="saveReply">
        <div class="d-flex gap-2">
            <input class="form-control form-control-sm" type="text" wire:model="content" placeholder="Add a reply">
            <button class="btn btn-sm btn-info float-end" type="submit"> Reply</button>
        </div>
        @error('content')
            <span class="text-danger small">{{ $message }}</span>
        @enderror
    </form>
</div>
