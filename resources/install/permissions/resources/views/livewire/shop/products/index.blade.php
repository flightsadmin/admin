@section('title', __('Products'))
<div class="card">
    <div class="card-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div class="float-left">
                <h5>Products </h5>
            </div>
            <div>
                <input wire:model.live.debounce.500ms="keyWord" type="text" class="form-control form-control-sm"
                    name="search" id="search" placeholder="Search Products">
            </div>
            <div class="d-flex gap-2">
                <input wire:model="productCount" type="text" size="4">
                <button wire:click.prevent="seedProducts" class="btn btn-warning btn-sm bi bi-cloud-upload-fill"> Seed
                    Products</button>
            </div>
            <div class="btn btn-sm btn-info bi bi-plus-lg" data-bs-toggle="modal" data-bs-target="#dataModal">
                Add Product
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('livewire.shop.products.modals')
        <div class="col-md-12">
            <div class="row g-4">
                @forelse ($products as $product)
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div>
                                <button data-bs-toggle="modal" data-bs-target="#viewModal"
                                    style="height: 200px; width: 100%; position: relative;"
                                    class="btn text-decoration-none"
                                    wire:click="edit({{ $product->id }})">
                                    <img class="card-img-top rounded mb-2" src="{{ asset('storage/' . $product->image) }}"
                                        style="height: 200px; width: 100%;" alt="{{ $product->id }}">
                                    <span
                                        class="text-danger h3 position-absolute top-0 end-0 p-3 {{ $product->featured ? 'bi bi-heart-fill' : '' }}">
                                    </span>
                                </button>
                            </div>
                            <div class="card-body">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>{{ $product->name }}</div>
                                    <div class="small text-muted">{{ $product->published_at->format('F d, Y') }}</div>
                                    <div class="dropdown float-end">
                                        <a class="btn custom-btn-sm btn-secondary dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Actions
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a data-bs-toggle="modal" data-bs-target="#dataModal"
                                                    class="dropdown-item bi bi-pencil-square"
                                                    wire:click="edit({{ $product->id }})"> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item bi bi-trash3"
                                                    onclick="confirm('Confirm Delete Registration id {{ $product->id }}? \nDeleted Registration cannot be recovered!')||event.stopImmediatePropagation()"
                                                    wire:click="destroy({{ $product->id }})"> Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="h4 mb-3">{{ $product->title }}</div>
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No Products</p>
                @endforelse
            </div>
            <div class="float-end mt-2">{{ $products->links() }}</div>
        </div>
    </div>
</div>