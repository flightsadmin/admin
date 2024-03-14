@section('title', __('Blog'))
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div class="float-left">
                <h5>Posts </h5>
            </div>
            <div>
                <input wire:model.live.debounce.500ms="keyWord" type="text" class="form-control form-control-sm"
                    name="search" id="search" placeholder="Search Posts">
            </div>
            <div class="d-flex gap-2">
                <input wire:model="postCount" type="text" size="4">
                <button wire:click.prevent="seedPosts" class="btn btn-warning btn-sm bi-cloud-upload-fill"> Seed
                    Posts</button>
            </div>
            <div class="btn btn-sm btn-info bi-plus-lg" data-bs-toggle="modal" data-bs-target="#dataModal">
                Add Post
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('livewire.admin.posts.modals')
        <div class="col-md-12">
            <div class="row g-4">
                @forelse ($posts as $post)
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div>
                                <button data-bs-toggle="modal" data-bs-target="#viewModal"
                                    style="height: 200px; width: 100%; position: relative;"
                                    class="btn text-decoration-none"
                                    wire:click="edit({{ $post->id }})">
                                    <img class="rounded mb-2" src="{{ asset('storage/' . $post->image) }}"
                                        style="height: 200px; width: 100%;" alt="{{ $post->id }}">
                                    <span
                                        class="text-danger h3 position-absolute top-0 end-0 p-3 {{ $post->featured ? 'bi-heart-fill' : '' }}">
                                    </span>
                                </button>
                            </div>
                            <div class="card-body">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div class="small text-muted">{{ $post->published_at->format('F d, Y') }}</div>
                                    <span class="float-end"> @livewire('blog.like-button', ['post' => $post], key($post->id))
                                    </span>
                                    <div class="dropdown float-end">
                                        <a class="btn custom-btn-sm btn-secondary dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a data-bs-toggle="modal" data-bs-target="#dataModal"
                                                    class="dropdown-item bi-pencil-square"
                                                    wire:click="edit({{ $post->id }})"> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item bi-trash3"
                                                    onclick="confirm('Confirm Delete Registration id {{ $post->id }}? \nDeleted Registration cannot be recovered!')||event.stopImmediatePropagation()"
                                                    wire:click="destroy({{ $post->id }})"> Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="h4 mb-3">{{ $post->title }}</div>
                                <p>{{ $post->getExcerpt() }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No Posts</p>
                @endforelse
            </div>
            <div class="float-end mt-2">{{ $posts->links() }}</div>
        </div>
    </div>
</div>