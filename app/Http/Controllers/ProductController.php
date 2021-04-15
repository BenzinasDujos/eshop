<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function show($id)
    {
        $product = Product::find($id);
        if ($product === null) {
            echo "<script>";
            echo "alert('Product with this ID does not exist')";
            echo "</script>";
        } else {
            return $product->toJson(JSON_PRETTY_PRINT);
        }
    }
}
