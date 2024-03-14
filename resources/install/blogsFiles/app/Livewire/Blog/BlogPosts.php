<?php

namespace App\Livewire\Blog;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Comment;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BlogPosts extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public function show(Post $post)
    {
        $comments = $post->comments()->with('author')->get();
        return view('livewire.blog.view-post', compact('post', 'comments'))->extends('components.layouts.admin');
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = $category->posts()->paginate(6);

        return view('livewire.blog.category', compact('category', 'posts'));
    }

    public function archive($year, $month)
    {
        $posts = Post::whereYear('published_at', $year)->whereMonth('published_at', $month)->get();
        return view('livewire.blog.archive', compact('posts'));
    }

    public function render()
    {
        // $archives = Post::selectRaw('YEAR(published_at) as year, MONTH(published_at) as month')
        //     ->groupBy('year', 'month')->latest('year')->latest('month')->get();
        
        $archives = Post::selectRaw("strftime('%Y', published_at) as year, strftime('%m', published_at) as month")
            ->groupBy('year', 'month')->orderBy('year', 'desc')->orderBy('month', 'desc')->get(); //For Sqllite

        $posts = Post::where('published_at', '<=', Carbon::now())->latest()->paginate(10);

        $featuredPosts = Post::where('featured', true)->latest()->paginate(5);

        return view('livewire.blog.blog-posts', compact('posts', 'featuredPosts', 'archives'))->extends('components.layouts.admin');
    }
}