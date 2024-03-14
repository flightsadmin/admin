<?php

namespace App\Livewire\Blog;

use App\Models\Post;
use Livewire\Component;

class LikeButton extends Component
{
    #[Reactive]
    public Post $post;

    public function toggleLike() {
        if(auth()->guest()) {
            return $this->redirect(route('login'), true);
        }
        $user = auth()->user();

        if ($this->post->likes()->where('user_id', $user->id)->exists()) {
            $this->post->likes()->where(['user_id' => $user->id])->delete();
            return;
        } 
        $this->post->likes()->create(['user_id' => $user->id]);
        
    }
    public function render()
    {
        return view('livewire.blog.like-button');
    }
}