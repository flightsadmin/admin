<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Post;
use Livewire\Component;
use App\Models\Category;
use App\Models\PostComment;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BlogPosts extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function show(Post $post) {
        $comments = PostComment::where('post_id', $post->id)->with('user')->get();
        return view('livewire.front.view-post', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
    
        $posts = $category->posts;
    
        return view('livewire.front.category', compact('category', 'posts'));
    }

    public function archive($year, $month)
    {
        $posts = Post::whereYear('published_at', $year)
            ->whereMonth('published_at', $month)->get();

        return view('livewire.front.archive', compact('posts'));
    }

    public function render()
    {
        $archives   = Post::selectRaw('YEAR(published_at) as year, MONTH(published_at) as month')
                    ->groupBy('year', 'month')->latest('year')->latest('month')->get();
        $posts      = Post::where('published_at', '<=', Carbon::now())->paginate(6);
        $featuredPosts = Post::where('featured', true)->paginate(4);
        return view('livewire.front.blog-posts', compact('posts', 'featuredPosts', 'archives'));
    }
}