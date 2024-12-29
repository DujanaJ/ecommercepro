<?php
namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAllProducts($paginate = 10)
    {
        return Product::paginate($paginate);
    }

    public function getProductById($id)
    {
        return Product::find($id);
    }

    public function searchProducts($searchText, $paginate = 10)
    {
        return Product::where('title', 'LIKE', "%$searchText%")
                      ->orWhere('category', 'LIKE', "%$searchText%")
                      ->paginate($paginate);
    }
}
