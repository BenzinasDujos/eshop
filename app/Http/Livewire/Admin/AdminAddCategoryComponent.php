<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Illuminate\View\View;
use Livewire\Component;
use Illuminate\Support\Str;

class AdminAddCategoryComponent extends Component
{
    public $name;
    public $slug;

    /**
     * @return void
     */
    public function generateSlug(): void
    {
        $this->slug = Str::slug($this->name, '-');
    }

    /**
     * @param string $fields
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updated(string $fields): void
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'slug' => 'required|unique:categories'
        ]);
    }

    /**
     * @return void
     */
    public function storeCategory(): void
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories'
        ]);
        $category = new Category();
        $category->name = $this->name;
        $category->slug = $this->slug;
        $category->save();
        session()->flash('message', 'Category has been added');
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.admin.admin-add-category-component')->layout('layouts.base');
    }
}
