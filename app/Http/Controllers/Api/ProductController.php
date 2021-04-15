<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Product::all();
    }

    /**
     * @param int $id
     * @return string
     */
    public function show(int $id): string
    {
        $product = Product::find($id);
        if ($product === null) {
            $product = '';
            echo "<script>";
            echo "alert('Product with this ID does not exist')";
            echo "</script>";
            return $product;
        }
        return $product->toJson(JSON_PRETTY_PRINT);
    }
}
