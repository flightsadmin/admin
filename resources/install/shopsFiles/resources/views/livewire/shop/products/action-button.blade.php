<div class="d-flex justify-content-center gap-2 justify-content-between">
    <button wire:loading.attr="disabled" wire:click="toggleLike" class="btn btn-sm btn-outline-success">
        <div wire:loading wire:target="toggleLike" class="spinner-border"
            style="width: 0.8rem; height: 0.8rem; border-width: 0.1rem;" role="status">
        </div>
        <span wire:loading.delay.remove class="{{ $product->likes()->where('user_id', auth()->user()?->id)->exists() ? 'text-danger' : '' }} bi-heart-fill">
            {{ $product->likes()->count() }} Likes</span>
    </button>

    <button wire:loading.attr="disabled" wire:click="toggleCart" class="btn btn-sm btn-outline-success">
        <div wire:loading wire:target="toggleCart" class="spinner-border"
            style="width: 0.8rem; height: 0.8rem; border-width: 0.1rem;" role="status">
        </div>
        <span wire:loading.delay.remove class="{{ Auth::user()?->hasAdded($product) ? 'text-danger' : '' }} bi-cart-check-fill">
            {{ Auth::user()?->hasAdded($product) ? 'Remove from Cart' : 'Add to Cart' }}</span>
    </button>
</div>