<?php

namespace App\Livewire;

use App\Models\Reply;
use App\Models\Comment;
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
        return view('livewire.front.comment', [
            'comments' => Comment::where('post_id', $this->post->id)->get(),
        ]);
    }

    public function addComment()
    {
       $comment = Comment::create([
            'user_id' => Auth::user()->id,
            'post_id' => $this->post->id,
            'content' => $this->commentContent,
        ]);
        $this->reset(['commentContent']);
    }

    public function addReply($commentId)
    {
        Reply::create([
            'user_id' => Auth::user()->id,
            'comment_id' => $commentId,
            'content' => $this->replyContent,
        ]);
        $this->reset(['replyContent']);
    }
}
