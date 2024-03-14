<?php

namespace App\Livewire\Shop;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Comments extends Component
{
    public $product;
    public $commentContent;
    public $replyContent;
    public $toggleReply;

    public function render()
    {
        return view('livewire.shop.products.comment', [
            'comments' => $this->product->comments,
        ]);
    }

    public function addComment()
    {
        $this->validate([
            'commentContent' => 'required|max:255'
        ]);
        $this->product->comments()->create([
            'user_id' => Auth::id(),
            'active' => true,
            'content' => $this->commentContent,
        ]);

        $this->reset(['commentContent']);
    }

    public function addReply($commentId)
    {
        $this->validate([
            'replyContent' => 'required|max:255'
        ]);
        $this->product->replies()->create([
            'user_id' => Auth::id(),
            'content' => $this->replyContent,
        ]);

        $this->reset(['replyContent']);
    }
}