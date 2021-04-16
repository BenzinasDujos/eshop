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

class CategoryComponent extends Component
{
    use WithPagination;
    public $sorting;
    public $pageSize;
    public $category_slug;

    /**
     * @param string $category_slug
     * @return void
     */
    public function mount(string $category_slug): void
    {
        $this->sorting = 'default';
        $this->pageSize = 12;
        $this->category_slug = $category_slug;
    }

    /**
     * @param int $product_id
     * @param string $product_name
     * @param float $product_price
     * @return RedirectResponse
     */
    public function store(int $product_id, string $product_name, float $product_price): Redirector
    {
        Cart::add($product_id, $product_name, 1, $product_price)->associate('App\Models\Product');
        session()->flash('success_message', 'Item added in cart');
        return redirect()->route('product.cart');
    }

    /**
     * @param int $category_id
     * @param string $orderByField
     * @param string $orderByRule
     * @return LengthAwarePaginator
     */
    public function paginate(int $category_id, string $orderByField = '', string $orderByRule = ''): LengthAwarePaginator
    {
        if ($orderByField !== '' && $orderByRule !== '') {
            $products = Product::where('category_id', $category_id)->orderBy($orderByField, $orderByRule)->paginate($this->pageSize);
        } else {
            $products = Product::where('category_id', $category_id)->paginate($this->pageSize);
        }
        return $products;
    }

    /**
     * @return View
     */
    public function render(): View
    {
        $category = Category::where('slug', $this->category_slug)->first();
        $category_id = $category->id;
        $category_name = $category->name;
        if ($this->sorting === 'date') {
            $products = $this->paginate($category_id, 'category_id', 'DESC');
        } else if ($this->sorting === 'price') {
            $products = $this->paginate($category_id, 'regular_price', 'ASC');
        } else if ($this->sorting === 'price-desc') {
            $products = $this->paginate($category_id, 'regular_price', 'DESC');
        } else {
            $products = $this->paginate($category_id);
        }

        $categories = Category::all();

        return view('livewire.category-component', ['products' => $products, 'categories' => $categories, 'category_name' => $category_name])->layout('layouts.base');
    }
}


