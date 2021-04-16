<?php

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use App\Models\Product;
use Cart;
use Livewire\Redirector;

class DetailsComponent extends Component
{
    public $slug;

    /**
     * @param string $slug
     * @return void
     */
    public function mount(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @param int $product_id
     * @param string $product_name
     * @param float $product_price
     * @return Redirector
     */
    public function store(int $product_id, string $product_name, float $product_price): Redirector
    {
        Cart::add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        session()->flash('success_message', 'Item added in cart');
        return redirect()->route('product.cart');
    }

    /**
     * @return View
     */
    public function render(): View
    {
        $product = Product::where('slug', $this->slug)->first();
        $popular_products = Product::inRandomOrder()->limit(4)->get();
        $related_products = Product::where('category_id', $product->category_id)->inRandomOrder()->limit(5)->get();
        return view('livewire.details-component', ['product' => $product, 'popular_products' => $popular_products, 'related_products' => $related_products])->layout('layouts.base');
    }
}
