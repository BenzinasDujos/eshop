<?php

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Cart;

class CartComponent extends Component
{
    /**
     * @param string $rowId
     * @return void
     */
    public function increaseQuantity(string $rowId): void
    {
        $product = Cart::get($rowId);
        $qty = $product->qty + 1;
        Cart::update($rowId, $qty);
    }

    /**
     * @param string $rowId
     * @return void
     */
    public function decreaseQuantity(string $rowId): void
    {
        $product = Cart::get($rowId);
        $qty = $product->qty - 1;
        Cart::update($rowId, $qty);
    }

    /**
     * @param string $rowId
     * @return void
     */
    public function destroy(string $rowId): void
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
