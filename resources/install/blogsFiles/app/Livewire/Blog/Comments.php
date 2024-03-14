<?php

namespace App\Livewire\Blog;

use App\Models\Reply;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Comments extends Component
{
    public $post;
    public $commentContent;
    public $replyContent;
    public $toggleReply;

    public function render()
    {
        return view('livewire.blog.comment', [
            'comments' => $this->post->comments,
        ]);
    }

    public function addComment()
    {
        $this->validate([
            'commentContent' => 'required|max:255'
        ]);
        $this->post->comments()->create([
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
        $this->post->replies()->create([
            'user_id' => Auth::id(),
            'comment_id' => $commentId,
            'content' => $this->replyContent,
        ]);

        $this->reset(['replyContent']);
    }
}