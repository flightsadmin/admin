<div wire:ignore.self class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">
                    {{ $board_id ? ' Edit Board' : 'Create New Board' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col-md-6 mb-2">
                            <label for="title">Title</label>
                            <input type="text" id="title" class="form-control" wire:model.lazy="title" autocomplete="off">
                            @error('title')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 mb-2">
                            <label for="body">Board Description</label>
                            <input id="body" type="hidden" wire:model.lazy="body">
                            <trix-editor input="body" x-data="{}" x-on:trix-change="$wire.body = $event.target.value"
                                x-ref="trix-editor"
                                x-on:trix-initialize="$wire.board_id ? $refs['trix-editor'].editor.loadHTML($wire.body) : ''">
                            </trix-editor>
                            @error('body')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button wire:click.prevent="save" type="button" class="btn btn-sm btn-primary bi-check2-circle"> Save</button>
            </div>
        </div>
    </div>
</div>
