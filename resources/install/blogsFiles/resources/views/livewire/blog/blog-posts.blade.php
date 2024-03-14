@extends('components.layouts.admin')
@section('title', __('Blog'))
@section('content')
    <div class="container-fluid">
        <!-- Page header with logo and tagline-->
        <header class="py-2 border-bottom mb-4">
            <div class="container-fluid">
                <div class="text-center my-3">
                    <h1 class="fw-bolder">Welcome to {{ config('admin.appName', 'app.name') }} Blog</h1>
                    <p class="lead mb-0">Refreshing, Every Post counts. Leave your comments</p>
                </div>
            </div>
        </header>
        <!-- Page content-->
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="row g-4">
                        @forelse ($posts as $post)
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <a wire:navigate href="{{ route('blog.show', $post->id) }}" class="gap-1 icon-link-hover">
                                        <img class="rounded mb-2" src="{{ asset('storage/' . $post->image) }}"
                                            style="height:200px; width:100%" alt="{{ $post->id }}">
                                    </a>
                                    <div class="card-body">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <div class="small text-muted">{{ $post->published_at->format('F d, Y') }}</div>
                                            <span class="float-end"> @livewire('like-button', ['post' => $post], key($post->id)) </span>
                                        </div>
                                        <div class="h4 mb-3">{{ $post->title }}</div>
                                        <p>{{ $post->getExcerpt() }}</p>
                                        <a wire:navigate href="{{ route('blog.show', $post->id) }}" class="">
                                            Read More... <span class="bi-chevron-right"></span>
                                        </a>
                                        <span class="float-end">{{ $post->getReadingTime() }} min read</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No Posts</p>
                        @endforelse
                    </div>
                    <div class="float-end mt-2">{{ $posts->links() }}</div>
                </div>
                <div class="col-md-4">
                    <div class="position-sticky" style="top: 2rem;">
                        <div class="card-body">
                            <div class="p-4 mb-3 bg-body-tertiary rounded">
                                <h4 class="fst-italic">About</h4>
                                <p class="mb-0">{{ config('admin.appName', 'app.name') }} is about simplicity. <br>
                                    {{ config('admin.purpose') }}, and get to know what's up around your world with our blog section.</p>
                            </div>
                            <div>
                                <h4 class="fst-italic">Featured posts</h4>
                                <ul class="list-unstyled">
                                    @forelse ($featuredPosts as $post)
                                        <li>
                                            <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top"
                                                wire:navigate href="{{ route('blog.show', $post->id) }}">
                                                <img src="{{ asset('storage/' . $post->image) }}" alt="" class="rounded mb-2"
                                                    width="100%" height="100">
                                                <div class="col-lg-8">
                                                    <h6 class="mb-0">{{ $post->title }}</h6>
                                                    <small class="text-body-secondary bi-clock">
                                                        {{ $post->published_at->format('d F, Y') }}</small>
                                                    <p class="small text-body-primary bi-person-circle"> {{ $post->author->name }}</p>
                                                </div>
                                            </a>
                                        </li>
                                    @empty
                                        <p>No Featured Posts</p>
                                    @endforelse
                                </ul>
                            </div>

                            <div class="p-4">
                                <h4 class="fst-italic">Archives</h4>
                                <ol class="list-unstyled mb-0">
                                    @foreach ($archives as $archive)
                                        <li>
                                            <a wire:navigate
                                                href="{{ route('blog.archive', ['year' => $archive->year, 'month' => $archive->month]) }}">
                                                {{ \Carbon\Carbon::createFromDate($archive->year, $archive->month, 1)->format('F Y') }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection