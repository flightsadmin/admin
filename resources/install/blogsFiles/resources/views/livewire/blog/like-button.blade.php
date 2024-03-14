<button wire:loading.attr="disabled" wire:click="toggleLike" class="btn btn-sm">
    <div wire:loading wire:target="toggleLike" class="spinner-border"
        style="width: 0.8rem; height: 0.8rem; border-width: 0.1rem;" role="status">
    </div>
    <span wire:loading.delay.remove class="{{ $post->likes()->where('user_id', auth()->user()?->id)->exists() ? 'text-danger' : '' }} bi-heart-fill">
        {{ $post->likes()->count() }} Likes
    </span>
</button>