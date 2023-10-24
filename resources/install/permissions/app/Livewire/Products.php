<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Products extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $product_id, $name, $price, $quantity, $description, $published_at, $image, $featured, $keyWord, $productCount, $categories;

    #[On('UpdateCart')]
    public function render()
    {
        $keyWord = '%' . $this->keyWord . '%';
        $category = Category::all();
        $products = Product::where('name', 'LIKE', $keyWord)->orWhere('price', 'LIKE', $keyWord)->paginate();
        return view('livewire.shop.products.index', compact('products', 'category'))->extends('components.layouts.admin');
    }

    public function store()
    {
        $validatedData = $this->validate([
            'name' => 'required|max:30',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'published_at' => 'nullable|date',
            'image' => 'nullable',
            'featured' => 'nullable',
        ]);

        $validatedData['user_id'] = Auth::id();
        if ($this->image && !is_string($this->image)) {
            $validatedData['image'] = $this->image->store('products', 'public');
        } else {
            unset($validatedData['image']);
        }
        $product = Product::updateOrCreate(['id' => $this->product_id], $validatedData);
        $product->categories()->sync($this->categories);
        $this->reset();
        $this->dispatch('closeModal');
    }

    public function edit($id)
    {
        $record = Product::findOrFail($id);
        $this->product_id = $id;
        $this->name = $record->name;
        $this->price = $record->price;
        $this->description = $record->description;
        $this->image = $record->image;
        $this->published_at = $record->published_at->format('Y-m-d\TH:i');
        $this->featured = $record->featured;
        $this->quantity = $record->quantity;
        $this->categories = $record->categories->pluck('id')->toArray();
    }

    public function show(Product $product)
    {
        $comments = $product->comments()->with('author')->get();

        $relatedProducts = Product::whereHas('categories', function ($query) use ($product) {
            $query->whereIn('categories.id', $product->categories->pluck('id'));
        })->where('id', '!=', $product->id)->get();
        return view('livewire.shop.products.view-product', compact('product', 'relatedProducts', 'comments'))->extends('components.layouts.admin');
    }

    #[On('UpdateCart')]
    public function renderUser()
    {
        $products = Product::where('quantity', '>', 0)->with('cartItems')->latest()->paginate();
        $featuredProducts = Product::where('featured', true)->latest()->paginate(5);
        return view('livewire.shop.products.view', compact('products', 'featuredProducts'))->extends('components.layouts.admin');
    }

    public function checkout()
    {
        return view('livewire.shop.products.checkout')->extends('components.layouts.admin');
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products()->paginate(6);

        return view('livewire.shop.products.category', compact('category', 'products'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image != 'products/default.png') {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
    }
}