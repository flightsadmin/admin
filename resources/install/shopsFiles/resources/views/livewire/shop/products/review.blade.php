<div class="col-12">
    <div class="product-review">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-variants-tab" data-bs-toggle="tab"
                    data-bs-target="#variants" type="button">Variants</button>

                <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab"
                    data-bs-target="#desc" type="button">Description</button>

                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab"
                    data-bs-target="#review" type="button">Review</button>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="variants">
                <div class="mt-4">
                    @foreach ($product->categories as $item)
                        <span class="ms-4 text-info">{{ $item->title }}</span>
                    @endforeach
                </div>
            </div>

            <div class="tab-pane fade show" id="desc">
                <div class="mt-4">
                    <h5 class="inner-title mb-2">{{ $product->name }}</h5>
                    <p class="font-light">{{ $product->description }} </p>
                </div>
            </div>

            <div class="tab-pane fade" id="review">
                <div class="row g-4">
                    <div class="col-lg-6 col-md-6 border">
                        <div class="p-2">
                            <h4>Customer reviews</h4>
                            <ul class="rating d-inline-block">
                                <div class="rating d-flex justify-content-center small gap-1 text-warning mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($product->likes->count()))
                                            <i class="bi-star-fill text-warning"></i>
                                        @else
                                            <i class="bi-star-fill text-secondary"></i>
                                        @endif
                                    @endfor
                                </div>
                            </ul>
                        </div>
                        <div class="col-12 mt-4">
                            <div class="customer-review-box">
                                @forelse ($product->likes as $item)
                                    <div class="customer-section">
                                        <div class="d-flex align-items-center gap-4">
                                            <img src="{{ asset('storage/' . $item->photo) }}"
                                                class="img-fluid profile-img" alt="">
                                            <h5>{{ $item->name }}</h5>
                                            <span class="fw-light text-end"> Created: {{ $item->created_at->format('F d, Y') }}</span>
                                        </div>
                                        <div class="mt-3">
                                            <p class="font-light ms-4">This is a product review.</p>
                                        </div>
                                    </div>
                                @empty
                                    <div>No Reviews for this Product yet</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 border">
                        <p class="d-inline-block me-2">Discussions</p>
                        <div class="review-box">
                            @livewire('action.comments', ['model' => $product])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
