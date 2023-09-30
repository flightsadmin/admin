<div>
    <!-- Add a new comment -->
    @auth
        <section class="mb-3">
            <div class="card-body">
                <div class="d-flex gap-4">
                    <form class="col-md-10 mb-4">
                        <textarea wire:model="commentContent" class="form-control" rows="2" placeholder="Join the discussion and leave a comment!"></textarea>
                        @error('commentContent') <span class="text-danger small">{{ $message }}</span> @enderror
                    </form>
                    <span class="col-md-2">
                        <button wire:click.prevent="addComment" class="btn btn-sm btn-primary"> Save Comment</button>
                    </span>
                </div>
            </div>
        </section>
    @else
        <div class="mb-4">
            <a wire:navigate href="{{ route('login') }}">Login to Post Comments</a>
        </div>
    @endauth
    <!-- Display comments -->
    <div class="mb-4 h4">Comments</div>
    @forelse ($comments as $comment)
        <div wire:key="{{ $comment->id }}" class="d-flex row">
            <div class="d-flex mb-4 col-md-8">
                <div class="flex-shrink-0">
                    <img class="rounded-circle profile-img" src="{{ asset('storage/' . $post->author->photo) }}"
                        alt="..." />
                </div>
                <div class="ms-4">
                    <div class="fw-bold">{{ $comment->author->name }}</div>
                    <div class="bi bi-chat-text"> {{ $comment->content }}</div>
                </div>
            </div>
            <div class="col-md-4">
                @auth
                    <button class="btn btn-sm shadow mb-2" wire:click="$toggle('toggleReply')">
                        Reply <span class="bi bi-chat-text"></span>
                    </button>
                    @if ($toggleReply)
                        <form wire:submit.prevent="addReply({{ $comment->id }})">
                            <div class="d-flex gap-2">
                                <input class="form-control form-control-sm" type="text" wire:model="replyContent" placeholder="Add a reply">
                                <button class="btn btn-sm btn-info float-end" type="submit"> Reply</button>
                            </div>
                            @error('replyContent') <span class="text-danger small">{{ $message }}</span> @enderror
                        </form>
                    @endif
                @endauth
            </div>
        </div>
        <!-- Display replies -->
        @foreach ($comment->replies as $reply)
            <div class="d-flex mb-4" style="margin-left: 80px;">
                <div class="flex-shrink-0">
                    <img class="rounded-circle profile-img" src="{{ asset('storage/' . $reply->author->photo) }}" alt="..." />
                </div>
                <div class="ms-4">
                    <div class="fw-bold">{{ $reply->author->name }}</div>
                    <div class="ms-2"> {{ $reply->content }}</div>
                </div>
            </div>
        @endforeach
    @empty
        <p>No Comments for this Post</p>
    @endforelse
</div>