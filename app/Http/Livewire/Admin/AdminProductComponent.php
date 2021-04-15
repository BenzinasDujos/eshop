<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class AdminProductComponent extends Component
{
    use WithPagination;

    /**
     * @param int $id
     * @return void
     */
    public function deleteProduct(int $id): void
    {
        $product = Product::find($id);
        $product->delete();
        session()->flash('message', 'Product has been deleted');
    }

    /**
     * @return View
     */
    public function render(): View
    {
        $products = Product::paginate(10);
        return view('livewire.admin.admin-product-component', ['products' => $products])->layout('layouts.base');
    }
}
