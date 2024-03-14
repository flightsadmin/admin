@extends('components.layouts.admin')
@section('title', __('Product'))
@section('content')
    <div class="container-fluid">
        <section>
            <div class="px-3 px-lg-4 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6">
                        <img class="card-img-top mb-5 mb-md-0 rounded" src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->id }}" />
                    </div>
                    <div class="col-md-6">
                        <div class="mb-1">SKU: {{ $product->id }}
                            @foreach ($product->categories as $item)
                                <a wire:navigate href="{{ route('shop.category', ['slug' => $item->slug]) }}" 
                                    class="badge bg-secondary text-decoration-none link-light">{{ $item->title }}
                                </a>
                            @endforeach
                        </div>
                        <h1 class="display-5 fw-bolder">{{ $product->name }}</h1>
                        <div class="fs-5 mb-5">
                            <span class="text-decoration-line-through">{{ $product->price }}</span>
                            <span>{{ $product->price }}</span>
                        </div>
                        <p class="lead">{{ $product->description }}</p>
                        <div class="d-flex gap-3">
                            @livewire('shop.action-button', ['product' => $product], key($product->id))
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <h3>Product Details</h3>
                    @include('livewire.shop.products.review')
                </div>
            </div>
        </section>
        <section>
            <div class="px-4 px-lg-5 mt-5">
                <h2 class="fw-bolder mb-4">Related Products</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4">
                    @foreach ($relatedProducts as $item)
                        <div class="col mb-5">
                            <div class="card h-100">
                                @if ($item->featured)
                                    <div class="badge text-bg-danger position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                                @endif
                                <a wire:navigate href="{{ route('shop.show', $item->id) }}" class="gap-1 icon-link-hover">
                                    <img class="card-img-top" src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->id }}" />
                                </a>
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <h5 class="fw-bolder">{{ $item->name }}</h5>
                                        <div class="rating d-flex justify-content-center small gap-1 text-warning mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= round($item->likes->count()))
                                                    <i class="bi-star-fill text-warning"></i>
                                                @else
                                                    <i class="bi-star-fill text-secondary"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-muted text-decoration-line-through">${{ $item->price }}</span>
                                        ${{ $item->price }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
