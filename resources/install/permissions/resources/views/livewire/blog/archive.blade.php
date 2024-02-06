@extends('components.layouts.app')
@section('title', __('Archived Posts'))
@section('content')
    <div class="container-fluid px-5">
        <h1>Archived Posts</h1>
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
                                <div class="small text-muted">{{ $post->published_at->format('F d, Y') }}</div>
                                <div class="h4 mb-3">{{ $post->title }}</div>
                                <p>{{ $post->getExcerpt() }}</p>
                                <a wire:navigate href="{{ route('blog.show', $post->id) }}"
                                    class="icon-link gap-1 icon-link-hover stretched-link">
                                    Read More... <span class="bi-chevron-right"></span>
                                </a>
                                <span class="float-end">{{ $post->getReadingTime() }} min read</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No Posts Archived for this Period</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection