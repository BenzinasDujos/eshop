<?php

namespace App\Http\Livewire\User;

use Illuminate\View\View;
use Livewire\Component;

class UserDashboardComponent extends Component
{
    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.user.user-dashboard-component')->layout('layouts.base');
    }
}
