@extends('components.layouts.app')
@section('title', __('Blog'))
@section('content')
    <div>
        <!-- Page header with logo and tagline-->
        <header class="py-2 bg-light border-bottom mb-4">
            <div class="container-fluid">
                <div class="text-center my-3">
                    <h1 class="fw-bolder">Welcome to {{ config('admin.appName', 'app.name') }} Blog</h1>
                    <p class="lead mb-0">Refreshing, Every Post counts. Leave your comments</p>
                </div>
            </div>
        </header>
        <!-- Page content-->
        <div class="container-fluid px-5">
            <div class="row">
                <div class="col-md-8">
                    <div class="row g-4">
                        @forelse ($posts as $post)
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <a href="{{ route('blog.show', $post->id) }}">
                                        <img class="rounded mb-2" src="{{ asset('storage/' . $post->image) }}"
                                            style="height:200px; width:100%" alt="{{ $post->id }}">
                                    </a>
                                    <div class="card-body">
                                        <div class="small text-muted">{{ $post->published_at->format('F d, Y') }}</div>
                                        <div class="h4 mb-3">{{ $post->title }}</div>
                                        <p>{{ $post->getExcerpt() }}</p>
                                        <a href="{{ route('blog.show', $post->id) }}" class="icon-link gap-1 icon-link-hover stretched-link">
                                            Read More... <span class="bi bi-chevron-right"></span>
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
                                <p class="mb-0">{{ config('admin.appName', 'app.name') }} is about simplicity. <br> {{ config('admin.purpose') }},
                                    at the same
                                    time get to know yor world with our blog section.</p>
                            </div>
                            <div>
                                <h4 class="fst-italic">Featured posts</h4>
                                <ul class="list-unstyled">
                                    @forelse ($featuredPosts as $post)
                                        <li>
                                            <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top"
                                                href="{{ route('blog.show', $post->id) }}">
                                                <img src="{{ asset('storage/' . $post->image) }}" alt="" class="rounded mb-2"
                                                    width="100%" height="100">
                                                <div class="col-lg-8">
                                                    <h6 class="mb-0">{{ $post->title }}</h6>
                                                    <small class="text-body-secondary bi bi-clock">
                                                        {{ $post->published_at->format('d F, Y') }}</small>
                                                    <p class="small text-body-primary bi bi-person-circle"> {{ $post->author->name }}</p>
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
                                            <a href="{{ route('blog.archive', ['year' => $archive->year, 'month' => $archive->month]) }}">
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
