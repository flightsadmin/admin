@extends('components.layouts.admin')
@section('title', __('Product'))
@section('content')
    <div class="container-fluid">
        <!-- Page header with logo and tagline-->
        <header class="py-2 border-bottom mb-4">
            <div class="container-fluid">
                <div class="text-center my-3">
                    <h1 class="fw-bolder">Welcome to {{ setting('site_name') ?? config('app.name') }} Blog</h1>
                    <p class="lead mb-0">Refreshing, Every Product counts. Leave your comments</p>
                </div>
            </div>
        </header>
        <!-- Page content-->
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-2 row-cols-xl-3">
                        @forelse ($products as $product)
                            <div class="col mb-5">
                                <div class="card h-100">
                                    @if ($product->featured)
                                        <div class="badge text-bg-danger position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                                    @endif
                                    <!-- Product image-->
                                    <a wire:navigate href="{{ route('shop.show', $product->id) }}" class="gap-1 icon-link-hover">
                                        <img class="card-img-top" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->id }}" />
                                    </a>
                                    <!-- Product details-->
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <!-- Product name-->
                                            <h5 class="fw-bolder">{{ $product->name }}</h5>
                                            <!-- Product reviews-->
                                            <div class="rating d-flex justify-content-center small gap-1 text-warning mb-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= round($product->likes->count()))
                                                        <i class="bi-star-fill text-warning"></i>
                                                    @else
                                                        <i class="bi-star-fill text-secondary"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <!-- Product price-->
                                            <span class="text-muted text-decoration-line-through">$20.00</span>
                                            {{ $product->price }}
                                        </div>
                                    </div>
                                    <!-- Product actions-->
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        @livewire('shop.action-button', ['product' => $product], key($product->id))
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No Products</p>
                        @endforelse
                    </div>
                    <div class="float-end mt-2">{{ $products->links() }}</div>
                </div>
                <div class="col-md-4">
                    <div class="position-sticky" style="top: 2rem;">
                        <div class="card-body">
                            <div class="p-4 mb-3 bg-body-tertiary rounded">
                                @livewire('carts')
                            </div>
                            <div>
                                <h4 class="fst-italic">Featured Products</h4>
                                <ul class="list-unstyled">
                                    @forelse ($featuredProducts as $product)
                                        <li>
                                            <div
                                                class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 border-top">
                                                <a class="link-body-emphasis text-decoration-none"
                                                    wire:navigate href="{{ route('shop.show', $product->id) }}">
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="" class="rounded mb-2"
                                                        width="100%" height="100">
                                                </a>
                                                <div class="col-lg-8">
                                                    <h6 class="mb-0">{{ $product->name }}</h6>
                                                    <small class="text-body-secondary bi-clock">
                                                        {{ $product->published_at->format('d F, Y') }}</small>
                                                    <p class="small text-body-primary bi-person-circle"> {{ $product->author->name }}</p>
                                                    <div>@livewire('shop.action-button', ['product' => $product], key($product->id))</div>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <p>No Featured Products</p>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection