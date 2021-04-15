<?php

namespace App\Http\Livewire\Admin;

use Illuminate\View\View;
use Livewire\Component;

class AdminDashboardComponent extends Component
{
    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.admin.admin-dashboard-component')->layout('layouts.base');
    }
}
