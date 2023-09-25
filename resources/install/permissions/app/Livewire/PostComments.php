<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use App\Models\PostComment;
use Illuminate\Support\Facades\Auth;

class PostComments extends Component
{
    public $commentText, $postId;

    public function saveComment() {
        $comment = PostComment::create([
            'user_id' => Auth::user()->id,
            'post_id' => $this->postId,
            'comment' => $this->commentText,
        ]);
        $this->reset('commentText');
        $this->dispatch('commentCreated', $comment);
    }

    public function render()
    {
        return view('livewire.front.post-comments');
    }
}
