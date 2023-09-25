<div>
    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div class="float-left">
                    <h5>Posts </h5>
                </div>
                <div>
                    <input wire:model.live.debounce.500ms="keyWord" type="text" class="form-control form-control-sm" name="search" id="search" placeholder="Search Posts">
                </div>
                <div class="d-flex gap-2">
                    <input wire:model="postCount" type="text" size="4">
                    <button wire:click.prevent="seedPosts" class="btn btn-warning btn-sm bi bi-cloud-upload-fill"> Seed Posts</button>
                </div>
                <div class="btn btn-sm btn-info bi bi-plus-lg" data-bs-toggle="modal" data-bs-target="#dataModal">
                    Add Post
                </div>
            </div>
        </div>
        <div class="card-body">
            @include('livewire.posts.modals')
            <ul class="list-group">
                @forelse ($posts as $post)
                <li class="list-group-item d-flex">
                    <div class="p-3">
                        <strong>Title:</strong> {{ $post->title }}<br>
                        <strong>Slug:</strong> {{ $post->slug }}<br>
                        <strong>Content:</strong> {{ $post->getAdminExcerpt() }}<br>
                        <strong>Published At:</strong> {{ $post->published_at }}<br>
                        <strong>Featured:</strong> {{ $post->featured ? 'Yes' : 'No' }}<br>
                        <strong>Created By:</strong> {{ $post->author->name }}<br>
                    </div>
                    <div>
                        <img class="mb-2 float-end rounded" src="{{ asset('storage/' . $post->image) }}"  style="height:200px; width:200px;"  alt="{{ $post->id }}">
                    </div>
                    <div class="ms-4">
                        <div class="dropdown">
                            <a class="btn custom-btn-sm btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </a>
                            <ul class="dropdown-menu">
                                <li><a data-bs-toggle="modal" data-bs-target="#dataModal" class="dropdown-item bi bi-pencil-square" wire:click="edit({{$post->id}})"> Edit </a></li>
                                <li><a class="dropdown-item bi bi-trash3" onclick="confirm('Confirm Delete Registration id {{$post->id}}? \nDeleted Registration cannot be recovered!')||event.stopImmediatePropagation()" wire:click="destroy({{$post->id}})"> Delete </a></li>  
                            </ul>
                        </div>
                    </div>
                </li>
                @empty
                <h5 class="text-center" colspan="100%">No Posts Found </h5>
                @endforelse

                <div class="float-end mt-2">{{ $posts->links() }}</div>
            </ul>
        </div>
    </div>
</div>