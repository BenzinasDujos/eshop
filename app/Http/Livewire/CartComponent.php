<?php

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Cart;

class CartComponent extends Component
{
    /**
     * @param int $rowId
     * @return void
     */
    public function increaseQuantity(int $rowId): void
    {
        $product = Cart::get($rowId);
        $qty = $product->qty + 1;
        Cart::update($rowId, $qty);
    }

    /**
     * @param int $rowId
     * @return void
     */
    public function decreaseQuantity(int $rowId): void
    {
        $product = Cart::get($rowId);
        $qty = $product->qty - 1;
        Cart::update($rowId, $qty);
    }

    /**
     * @param int $rowId
     * @return void
     */
    public function destroy(int $rowId): void
    {
        Cart::remove($rowId);
        session()->flash('success_message', 'Item has been removed');
    }

    /**
     * @return void
     */
    public function destroyAll(): void
    {
        Cart::destroy();
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.cart-component')->layout('layouts.base');
    }
}
