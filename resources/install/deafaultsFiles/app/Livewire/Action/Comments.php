<?php

namespace App\Livewire\Action;

use App\Models\Post;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Comments extends Component
{
    public $model;
    public $toggleReply;
    public $content;
    public function render()
    {
        return view('livewire.admin.action.comment', [
            'comments' => $this->model->comments,
        ]);
    }

    public function mount($model)
    {
        $this->model = $model;
    }

    public function saveComment()
    {
        $this->validate([
            'content' => 'required|max:255'
        ]);

        $this->model->comments()->create([
            'user_id' => auth()->id(),
            'active' => true,
            'content' => $this->content,
        ]);

        $this->reset(['content']);
    }
}