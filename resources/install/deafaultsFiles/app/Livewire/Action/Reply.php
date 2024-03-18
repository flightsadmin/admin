<?php

namespace App\Livewire\Action;

use App\Models\Comment;
use Livewire\Component;

class Reply extends Component
{
    public $comment;
    public $content;

    public function mount(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function saveReply()
    {
        $this->validate([
            'content' => 'required|max:255'
        ]);

        $this->comment->replies()->create([
            'content' => $this->content,
            'user_id' => auth()->id(),
        ]);

        $this->reset(['content']);

        session()->flash('success', 'Reply added successfully.');
    }

    public function render()
    {
        return view('livewire.admin.action.reply');
    }
}
