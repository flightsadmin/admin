<div>
    <div class="card">
        <div class="card-header">
            <h5>Create Categories</h5>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="createCategory">
                <div class="row">
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
                        <button type="submit" class="btn btn-primary">Create Category</button>
                    </div>
                </div>
            </form>
            <h2 class="mt-4">Categories</h2>
            <ul class="list-group">
                @foreach ($posts as $post)
                    <li class="list-group-item d-flex">
                        <div>
                            <strong>Title:</strong> {{ $post->title }}<br>
                            <strong>Slug:</strong> {{ $post->slug }}<br>
                            <strong>Content:</strong> {{ $post->body }}<br>
                            <strong>Published At:</strong> {{ $post->published_at }}<br>
                            <strong>Featured:</strong> {{ $post->featured ? 'Yes' : 'No' }}<br>
                            <strong>Created By:</strong> {{ $post->user->name }}<br>
                        </div>
                        <div>
                            <img class="mb-2 float-end" src="{{ $post->image }}"  style="height:200px; width:200px;"  alt="{{ $post->id }}">
                        </div>
                    </li>
                @endforeach
                <div class="float-end">{{ $posts->links() }}</div>
            </ul>
        </div>
    </div>
</div>