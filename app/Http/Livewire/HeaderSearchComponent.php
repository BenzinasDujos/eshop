<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Illuminate\View\View;
use Livewire\Component;

class HeaderSearchComponent extends Component
{
    public $search;
    public $product_category;
    public $product_category_id;

    /**
     * @return void
     */
    public function mount(): void
    {
        $this->product_category = 'All Categories';
        $this->fill(request()->only('search', 'product_category', 'product_category_id'));
    }

    /**
     * @return View
     */
    public function render(): View
    {
        $categories = Category::all();
        return view('livewire.header-search-component', ['categories' => $categories]);
    }
}
