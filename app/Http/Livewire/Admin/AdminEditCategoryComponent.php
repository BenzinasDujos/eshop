<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Illuminate\View\View;
use Livewire\Component;
use Illuminate\Support\Str;

class AdminEditCategoryComponent extends Component
{
    public $category_slug;
    public $category_id;
    public $name;
    public $slug;

    /**
     * @param string $category_slug
     * @return void
     */
    public function mount(string $category_slug): void
    {
        $this->category_slug = $category_slug;
        $category = Category::where('slug', $category_slug)->first();
        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
    }

    /**
     * @return void
     */
    public function generateSlug(): void
    {
        $this->slug = Str::slug($this->name);
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
    public function updateCategory(): void
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories'
        ]);
        $category = Category::find($this->category_id);
        $category->name = $this->name;
        $category->slug = $this->slug;
        $category->save();
        session()->flash('message', 'Category has been updated');
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.admin.admin-edit-category-component')->layout('layouts.base');
    }
}
