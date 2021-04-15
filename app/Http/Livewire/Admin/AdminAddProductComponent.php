<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class AdminAddProductComponent extends Component
{
    use WithFileUploads;
    public $name;
    public $slug;
    public $short_description;
    public $description;
    public $regular_price;
    public $sale_price;
    public $sku;
    public $stock_status;
    public $featured;
    public $quantity;
    public $image;
    public $category_id;

    /**
     * @return void
     */
    public function mount(): void
    {
        $this->stock_status = 'instock';
        $this->featured = 0;
    }

    /**
     * @return void
     */
    public function generateSlug(): void
    {
        $this->slug = Str::slug($this->name, '-');
    }

    /**
     * @param string $fields
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updated(string $fields): void
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'slug' => 'required|unique:products',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required|numeric',
            'sale_price' => 'numeric',
            'sku' => 'required',
            'stock_status' => 'required',
            'quantity' => 'required|numeric',
            'image' => 'required|mimes:jpeg,png',
            'category_id' => 'required'
        ]);
    }

    /**
     * @return void
     */
    public function addProduct(): void
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required|unique:products',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required|numeric',
            'sale_price' => 'numeric',
            'sku' => 'required',
            'stock_status' => 'required',
            'quantity' => 'required|numeric',
            'image' => 'required|mimes:jpeg,png',
            'category_id' => 'required'
        ]);

        $product = new Product();
        $product->name = $this->name;
        $product->slug = $this->slug;
        $product->short_description = $this->short_description;
        $product->description = $this->description;
        $product->regular_price = $this->regular_price;
        $product->sale_price = $this->sale_price;
        $product->sku = $this->sku;
        $product->stock_status = $this->stock_status;
        $product->featured = $this->featured;
        $product->quantity = $this->quantity;
        $imageName = Carbon::now()->timestamp. '.' . $this->image->extension();
        $this->image->storeAs('products', $imageName);
        $product->image = $imageName;
        $product->category_id = $this->category_id;
        $product->save();
        session()->flash('message', 'Product has been created');
    }

    /**
     * @return View
     */
    public function render(): View
    {
        $categories = Category::all();
        return view('livewire.admin.admin-add-product-component', ['categories' => $categories])->layout('layouts.base');
    }
}
