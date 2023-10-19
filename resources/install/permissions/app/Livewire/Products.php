<?php

namespace App\Livewire;

use Carbon\Carbon;
use Faker\Factory;
use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Products extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    #[Rule('required|max:255')]
    public $name;
    #[Rule('required')]
    public $price;
    #[Rule('required|min:10')]
    public $description;
    #[Rule('nullable')]
    public $image;
    #[Rule('nullable|date')]
    public $published_at;
    #[Rule('nullable|boolean')]
    public $featured = false;
    
    public $product_id, $keyWord, $productCount, $categories;

    public function render()
    {
        $keyWord = '%'. $this->keyWord .'%';
        $category = Category::all();
        $products = Product::where('name', 'LIKE', $keyWord)->orWhere('price', 'LIKE', $keyWord)->paginate();
        return view('livewire.shop.products.index', compact('products', 'category'))->extends('components.layouts.admin');
    }
    
    public function store()
    {
        $validatedData = $this->validate();
        $validatedData['user_id'] =  Auth::id();
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
        $this->categories = $record->categories->pluck('id')->toArray();
    }

    public function show(Product $product)
    {
        $product = $product->load('categories');
        $comments = $product->comments()->with('author')->get();

        $relatedProducts = Product::whereHas('categories', function ($query) use ($product) {
            $query->whereIn('categories.id', $product->categories->pluck('id'));
        })->where('id', '!=', $product->id)->get();
        return view('livewire.shop.products.view-product', compact('product', 'relatedProducts', 'comments'))->extends('components.layouts.app');
    }

    public function renderUser()
    {    
        $products = Product::where('published_at', '<=', Carbon::now())->with('cartItems')->latest()->paginate();
        $featuredProducts = Product::where('featured', true)->latest()->paginate(5);
        return view('livewire.shop.products.view', compact('products', 'featuredProducts'))->extends('components.layouts.app');
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products()->paginate(6);

        return view('livewire.shop.category', compact('category', 'products'));
    }

    public function destroy($id)
    {        
        $product = Product::findOrFail($id);
        
        if($product->image != 'products/default.png') {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
    }
}