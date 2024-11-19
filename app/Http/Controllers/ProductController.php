<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductListResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function home()
    {
        $products = Product::query()
            ->published()
            ->paginate(12);

        return Inertia::render('Home', [
            'products' => ProductListResource::collection($products)
        ]);
    }

    public function show(Product $product)
    {

    }
}
