<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Redirector;
use Livewire\WithPagination;
use Cart;
use App\Models\Category;

class ShopComponent extends Component
{
    use WithPagination;
    public $sorting;
    public $pageSize;

    /**
     * @return void
     */
    public function mount(): void
    {
        $this->sorting = 'default';
        $this->pageSize = 12;
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
     * @param string $orderByField
     * @param string $orderByRule
     * @return LengthAwarePaginator
     */
    public function paginate(string $orderByField = '', string $orderByRule = ''): LengthAwarePaginator
    {
        if ($orderByField !== '' && $orderByRule !== '') {
            $products = Product::orderBy($orderByField, $orderByRule)->paginate($this->pageSize);
        } else {
            $products = Product::paginate($this->pageSize);
        }
        return $products;
    }

    /**
     * @return View
     */
    public function render(): View
    {
        if ($this->sorting === 'date') {
            $products = $this->paginate('created_at', 'DESC');
        } else if ($this->sorting === 'price') {
            $products = $this->paginate('regular_price', 'ASC');
        } else if ($this->sorting === 'price-desc') {
            $products = $this->paginate('regular_price', 'DESC');
        } else {
            $products = $this->paginate();
        }

        $categories = Category::all();

        return view('livewire.shop-component', ['products' => $products, 'categories' => $categories])->layout('layouts.base');
    }
}


