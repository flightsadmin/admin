<?php

namespace App\Livewire;

use Faker\Factory;
use App\Models\Post;
use App\Models\User;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
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
    #[Rule('boolean')]
    public $featured;

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
        $this->reset();
        $this->dispatch('closeModal');
        session()->flash('message', $this->post_id ? 'Post Updated Successfully.' : 'Post Created Successfully.');
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
        Post::findOrFail($id)->delete();
        session()->flash('message', 'Post Deleted Successfully.');
    }

    public function seedPosts() {
        $faker = Factory::create();
        $users = User::all();
        foreach ($users as $user) {
            for ($i=0; $i < $this->postCount; $i++) { 
                $title = $faker->realText(20);
                $post = Post::create([
                    'user_id' => $user->id,
                    'title' => preg_replace('/[^A-Za-z0-9 ]/', '', $title),
                    'slug' => strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9 ]/', '', $title))),
                    'image' => 'posts/default.png',
                    'body' => $faker->realTextBetween(2000, 5000, 2),
                    'published_at' => $faker->dateTimeBetween('-1 Month', '+1 Month'),
                    'featured' => $faker->boolean(10)
                ]);
                $post->categories()->attach($faker->randomElements(['1', '2', '3', '4', '5', '6', '7', '8', '9'], $faker->randomDigitNotNull()));
            }
        }
        $this->reset('postCount');
    }
}