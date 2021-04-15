<?php

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class CheckoutComponent extends Component
{
    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.checkout-component')->layout('layouts.base');
    }
}
