@extends('components.layouts.admin')
@section('title', __('Blog Post'))
@section('content')
    <div class="container-fluid px-5">
        <div class="row justify-content-center">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-lg-8">
                        <article>
                            <header class="mb-4">
                                <h1 class="fw-bolder mb-1">{{ $post->title }}</h1>
                                <div class="text-muted fst-italic mb-2" style="display: flex; justify-content: space-between; align-items: right;">
                                    Posted on {{ $post->published_at->format('F d, Y') }} by {{ $post->author->name }}
                                    <p class="bi-chat-dots-fill me-4"> {{ $post->comments->count() }} Comments</p>
                                    <p class="bi-clock-fill"> {{ $post->getReadingTime() }} min read</p>
                                    <p>@livewire('like-button', ['post' => $post], key($post->id))</p>
                                </div>
                            </header>
                            <!-- Preview image figure-->
                            <div class="mb-4"><img class="img-fluid rounded"
                                    src="{{ asset('storage/' . $post->image) }}" alt="thumbnail"
                                    style="height:400px; width:100%" /></div>
                            <!-- Post content-->
                            <section class="mb-5">
                                {{-- {!! nl2br(e($post->body)) !!} --}}
                                {!! $post->body !!}
                            </section>
                        </article>
                        <!-- Comments section-->
                        @livewire('blog.comments', ['post' => $post])
                    </div>
                    <!-- Side widgets-->
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header p-2">Categories</div>
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
                        </div>
                        <div class="card mb-4">
                            <div class="card-header p-2">Author</div>
                            <div class="card-body d-flex gap-4 align-items-center">
                                <div class="justify-content-center">
                                    <img class="rounded profile-img mb-2 ml-2"
                                        src="{{ asset('storage/' . $post->author->photo) }}"
                                        alt="{{ $post->author->name }}">
                                    <div class="text-muted">{{ $post->author->name }}</div>
                                </div>
                                <div class="float-end">Total Categories: {{ $post->categories->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
