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
                <div wire:ignore class="col-md-12 mb-4">
                    <div class="mb-2" id="editor">{{ $body }}</div>
                </div>
                <form>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="body" class="form-label">Content</label>
                            <textarea class="form-control" wire:model="body" id="quill-textarea"></textarea>
                            @error('body') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input wire:model="title" type="text" id="title" name="title" class="form-control">
                            @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input wire:model="slug" type="text" id="slug" name="slug" class="form-control">
                            @error('slug') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input wire:model="image" type="file" id="image" name="image" class="form-control">
                            @error('image') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="published_at" class="form-label">Published At</label>
                            <input wire:model="published_at" type="datetime-local" id="published_at" name="published_at" class="form-control" id="published_at">
                            @error('published_at') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="categories" class="form-label">Categories</label>
                            <select wire:model="categories" class="form-select" multiple aria-label="Multiple select example">
                                <option value="">Choose an option...</option>
                                @foreach ($category as $item)
                                    <option value="{{$item->id}}">{{$item->title}}</option>                                    
                                @endforeach
                            </select>
                            @error('categories') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3 form-check align-content-center">
                            <input wire:model="featured" type="checkbox" id="featured" name="featured" class="form-check-input">
                            <label class="form-check-label" for="featured">Featured</label>
                            @error('featured') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button wire:click.prevent="store" type="button" class="btn btn-sm btn-primary bi bi-check2-circle"> Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Success Message Toast  -->
<div  id="statusToast" class="toast position-fixed top-0 end-0 p-3 text-bg-success" style="margin-top:5px; margin-bottom:0px;" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header text-bg-success">
    <i class="me-2 bi bi-send-fill"></i>
    <strong class="me-auto text-black">Success</strong>
    <small class="text-white">{{ now() }}</small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body text-black text-center">
    {{ session('message') }}
  </div>
</div>