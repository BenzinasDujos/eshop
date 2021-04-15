<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;
use App\Models\Category;

class SearchComponent extends Component
{
    use WithPagination;
    public $sorting;
    public $pageSize;
    public $search;
    public $product_category;
    public $product_category_id;

    /**
     * @return void
     */
    public function mount(): void
    {
        $this->sorting = 'default';
        $this->pageSize = 12;
        $this->fill(request()->only('search', 'product_category', 'product_category_id'));
    }

    /**
     * @param int $product_id
     * @param string $product_name
     * @param float $product_price
     * @return RedirectResponse
     */
    public function store(int $product_id, string $product_name, float $product_price): RedirectResponse
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
            $products = Product::where('name', 'like', '%'.$this->search . '%')->where('category_id', 'like', '%'.$this->product_category_id.'%')->orderBy($orderByField, $orderByRule)->paginate($this->pageSize);
        } else {
            $products = Product::where('name', 'like', '%'.$this->search . '%')->where('category_id', 'like', '%'.$this->product_category_id.'%')->paginate($this->pageSize);
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

        return view('livewire.search-component', ['products' => $products, 'categories' => $categories])->layout('layouts.base');
    }
}


