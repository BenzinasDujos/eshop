<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCategoryComponent extends Component
{
    use WithPagination;

    /**
     * @param int $id
     * @return void
     */
    public function deleteCategory(int $id): void
    {
        $category = Category::find($id);
        $category->delete();
        session()->flash('message', 'Category has been deleted');
    }

    /**
     * @return View
     */
    public function render(): View
    {
        $categories = Category::paginate(5);
        return view('livewire.admin.admin-category-component', ['categories' => $categories])->layout('layouts.base');
    }
}
