<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\QueryBuilders\ProductIndexQuery;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ProductIndexQuery $productIndexQuery)
    {
        $request->validate([
            'per_page' => 'nullable|integer|gt:0'
        ]);

        $products = $productIndexQuery->paginate($request->per_page ?? 10);

        return response()->api([
            "products" => (new ProductCollection($products))->response()->getData(true)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();
        $product = Product::create($validatedData);

        $product->with(['website', 'reviews', 'brand', 'category']);
        return response()->api([
            'product' =>  new ProductResource($product),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->with(['website', 'reviews', 'brand', 'category']);
        return response()->api([
            'product' =>  new ProductResource($product),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validatedData = $request->validated();
        $product->update($validatedData);

        $product->with(['website', 'reviews', 'brand', 'category']);
        return response()->api([
            'product' =>  new ProductResource($product),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->api();
    }
}
