<?php

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class HomeComponent extends Component
{
    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.home-component')->layout('layouts.base');
    }
}
