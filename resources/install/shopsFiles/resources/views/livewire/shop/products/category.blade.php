@extends('components.layouts.admin')
@section('title', __('Categories'))
@section('content')
    <div>
        <header class="py-2 bg-light border-bottom mb-4">
            <div class="container-fluid">
                <div class="text-center my-3">

                    <p class="text-muted mb-0">All Products Containing Category: <span
                            class="fw-bolder badge bg-secondary text-decoration-none link-light">{{ $category->title }}</span>
                    </p>
                </div>
            </div>
        </header>
        <div class="container-fluid px-5">
            <div class="col-md-12">
                <div class="row g-4">
                    @forelse ($products as $product)
                        <div class="col-md-4">
                            <div class="card h-100">
                                <a wire:navigate href="{{ route('shop.show', $product->id) }}">
                                    <img class="rounded mb-2 icon-link gap-1 icon-link-hover stretched-link" src="{{ asset('storage/' . $product->image) }}"
                                        style="height:200px; width:100%" alt="{{ $product->id }}">
                                </a>
                                <div class="card-body">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="list-unstyled mb-0 d-flex flex-wrap">
                                                    @if ($product->categories->count() > 0)
                                                        @forelse($product->categories as $category)
                                                            <li class="px-1">
                                                                <a wire:navigate href="{{ route('shop.category', ['slug' => $category->slug]) }}"
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
                                    <div class="text-muted fst-italic mb-2" style="display: flex; justify-content: space-between; align-items: right;">
                                        <div class="small text-muted">{{ $product->published_at->format('F d, Y') }}</div>
                                        <p class="float-end">@livewire('action-button', ['product' => $product], key($product->id))</p>
                                    </div>
                                    <div class="h4 mb-3">{{ $product->name }}</div>
                                    <p>{{ $product->description }}</p>
                                    <a wire:navigate href="{{ route('shop.show', $product->id) }}"
                                        class="icon-link gap-1 icon-link-hover">
                                        Product Details <span class="bi-chevron-right"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No Products in this Category</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection