@extends('components.layouts.app')
@section('title', __('Categories'))
@section('content')
    <div>
        <header class="py-2 bg-light border-bottom mb-4">
            <div class="container-fluid">
                <div class="text-center my-3">

                    <p class="text-muted mb-0">All Posts Containing Category: <span
                            class="fw-bolder badge bg-secondary text-decoration-none link-light">{{ $category->title }}</span>
                    </p>
                </div>
            </div>
        </header>
        <div class="container-fluid px-5">
            <div class="col-md-12">
                <div class="row g-4">
                    @forelse ($posts as $post)
                        <div class="col-md-4">
                            <div class="card h-100">
                                <a wire:navigate href="{{ route('blog.show', $post->id) }}">
                                    <img class="rounded mb-2" src="{{ asset('storage/' . $post->image) }}"
                                        style="height:200px; width:100%" alt="{{ $post->id }}">
                                </a>
                                <div class="card-body">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="list-unstyled mb-0 d-flex flex-wrap">
                                                    @if ($post->categories->count() > 0)
                                                        @forelse($post->categories as $category)
                                                            <li class="px-1">
                                                                <a wire:navigate href="{{ route('blog.category', ['slug' => $category->slug]) }}"
                                                                    class="badge bg-secondary text-decoration-none link-light">{{ $category->title }}</a>
                                                            </li>
                                                        @empty
                                                            <p>No Categories</p>
                                                        @endforelse
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="small text-muted">{{ $post->published_at->format('F d, Y') }}</div>
                                    <div class="h4 mb-3">{{ $post->title }}</div>
                                    <p>{{ $post->getExcerpt() }}</p>
                                    <a wire:navigate href="{{ route('blog.show', $post->id) }}"
                                        class="icon-link gap-1 icon-link-hover stretched-link">
                                        Read More... <span class="bi bi-chevron-right"></span>
                                    </a>
                                    <span class="float-end">{{ $post->getReadingTime() }} min read</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No Posts in this Category</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
