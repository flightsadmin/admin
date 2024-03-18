<div wire:ignore.self class="modal fade" id="viewModal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Post</h5>
                <button wire:click="$refresh" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($post_id)
                    <div class="card h-100">
                        <img class="rounded mb-2" src="{{ asset('storage/' . $image) }}"
                            style="height:200px; width:100%" alt="{{ $title }}">
                        <div class="card-body">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="h4 mb-3">{{ $title }}</div>
                                <span class="text-success float-end"> {{ $featured ? 'Featured' : '' }}</span>
                                <div class="small text-muted float-end">{{ $published_at }}</div>
                            </div>
                            <div>{!! $body !!}</div>
                        </div>
                    </div>
                @else
                    <p>Loading Post...</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" wire:click="$refresh">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Create / Edit Post Modal -->
<div wire:ignore.self class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">
                    {{ $post_id ? 'Edit Post' : 'Create New Post' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="form-group col-md-12 mb-2">
                            <label for="body">Content</label>
                            <input id="body" type="hidden" wire:model.lazy="body">
                            <trix-editor input="body" x-data="{}" x-on:trix-change="$wire.body = $event.target.value"
                                x-ref="trix-editor"
                                x-on:trix-initialize="$wire.post_id ? $refs['trix-editor'].editor.loadHTML($wire.body) : ''">
                            </trix-editor>
                            @error('body')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input wire:model="title" type="text" id="title" name="title" class="form-control">
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input wire:model="slug" type="text" id="slug" name="slug" class="form-control">
                            @error('slug')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input wire:model="image" type="file" id="image" name="image" class="form-control">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="published_at" class="form-label">Published At</label>
                            <input wire:model="published_at" type="datetime-local" id="published_at" name="published_at"
                                class="form-control" id="published_at">
                            @error('published_at')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="categories" class="form-label">Categories</label>
                            <select wire:model="categories" class="form-select" multiple aria-label="Multiple select example">
                                <option value="">Choose an option...</option>
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('categories')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3 form-check align-content-center">
                            <input wire:model="featured" type="checkbox" id="featured" name="featured" class="form-check-input">
                            <label class="form-check-label" for="featured">Featured</label>
                            @error('featured')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
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