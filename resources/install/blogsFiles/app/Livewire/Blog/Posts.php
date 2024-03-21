<?php

namespace App\Livewire\Blog;

use Faker\Factory;
use App\Models\Post;
use App\Models\User;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Posts extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    #[Rule('required|max:255')]
    public $title;
    #[Rule('required')]
    public $slug;
    #[Rule('required|min:10')]
    public $body;
    #[Rule('nullable')]
    public $image;
    #[Rule('nullable|date')]
    public $published_at;
    #[Rule('nullable|boolean')]
    public $featured = false;

    public $post_id, $keyWord, $postCount, $categories;

    public function render()
    {
        $keyWord = '%'. $this->keyWord .'%';
        $category = Category::all();
        $posts = Post::where('title', 'LIKE', $keyWord)->orWhere('slug', 'LIKE', $keyWord)->paginate();
        return view('livewire.admin.posts.view', compact('posts', 'category'))->extends('components.layouts.admin');
    }
    
    public function store()
    {
        $validatedData = $this->validate();
        $validatedData['user_id'] =  Auth::id();
        if ($this->image && !is_string($this->image)) {
            $validatedData['image'] = $this->image->store('posts', 'public');
        } else {
            unset($validatedData['image']);
        }
        $post = Post::updateOrCreate(['id' => $this->post_id], $validatedData);
        $post->categories()->sync($this->categories); 
        $this->dispatch(
            'closeModal',
            icon: 'success',
            message: $this->post_id ? 'Post Updated Successfully.' : 'Post Created Successfully.',
        );
        $this->reset();
    }

    public function edit($id)
    {
        $record = Post::findOrFail($id);
        $this->post_id = $id;
        $this->title = $record->title;
        $this->slug = $record->slug;
        $this->body = $record->body;
        $this->image = $record->image;
        $this->published_at = $record->published_at->format('Y-m-d\TH:i');
        $this->featured = $record->featured;
        $this->categories = $record->categories->pluck('id')->toArray();
    }

    public function destroy($id)
    {        
        $post = Post::findOrFail($id);
        
        if($post->image != 'posts/default.png') {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();
        $this->dispatch(
            'closeModal',
            icon: 'warning',
            message: 'Post Deleted Successfully.',
        );
    }
}