<?php

namespace App\Livewire;

use App\Models\Reply;
use App\Models\Comment;
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
            'comments' => Comment::where('product_id', $this->product->id)->get(),
        ]);
    }

    public function addComment()
    {
        $this->validate([
            'commentContent' => 'required|max:255'
        ]);
        $comment = Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $this->product->id,
            'content' => $this->commentContent,
        ]);

        $this->reset(['commentContent']);
    }

    public function addReply($commentId)
    {
        $this->validate([
            'replyContent' => 'required|max:255'
        ]);
        Reply::create([
            'user_id' => Auth::id(),
            'comment_id' => $commentId,
            'content' => $this->replyContent,
        ]);
        $this->reset(['replyContent']);
    }
}