<div>
    <!-- Add a new comment -->
    @auth
        <section class="mb-3">
            <div class="card-body">
                <div class="d-flex gap-4">
                    <form class="col-md-10 mb-4">
                        <textarea wire:model="content" class="form-control" rows="2" placeholder="Join the discussion and leave a comment!"></textarea>
                        @error('content')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </form>
                    <span class="col-md-2">
                        <button wire:click.prevent="saveComment" class="btn btn-sm btn-primary"> Save Comment</button>
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
                    <img class="rounded-circle profile-img" src="{{ asset('storage/' . $model->author->photo) }}"
                        alt="..." />
                </div>
                <div class="ms-4">
                    <div class="fw-bold">{{ $comment->author->name }}</div>
                    <div class="bi-chat-text"> {{ $comment->content }}</div>
                </div>
            </div>
            <div class="col-md-4">
                @auth
                    <button class="btn btn-sm shadow mb-2" wire:click="$toggle('toggleReply')">
                        Reply <span class="bi-chat-text"></span>
                    </button>
                    @if ($toggleReply)
                        @livewire('action.reply', ['comment' => $comment], key($comment->id))
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
