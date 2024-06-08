<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Services\Product\SaveProductData;
use App\Jobs\ReviewsHandlingJob;
use App\Models\Brand;
use App\Models\Recent;
use App\Models\Website;
use App\QueryBuilders\ProductIndexQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

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

        $product->with(['website', 'reviews', 'brand']);
        return response()->api([
            'product' =>  new ProductResource($product),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['website', 'reviews', 'brand']);
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

        $product->load(['website', 'reviews', 'brand']);
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


    /**
     *returns brand's products
     */
    public function getBrandProducts(Request $request)
    {

        $brandId = $request->query('brand_id');
        $products = Brand::find($brandId)->products->paginate(10);

        return response()->api([
            "products" => (new ProductCollection($products))->response()->getData(true)
        ]);
    }

    /**
     *returns brand's products
     */
    public function getWebsiteProducts(Request $request)
    {

        $websiteId = $request->query('website_id');
        $products = Website::find($websiteId)->products->paginate(10);

        return response()->api([
            "products" => (new ProductCollection($products))->response()->getData(true)
        ]);
    }

    /**
     *returns recomended products
     */
    public function recommendedProducts()
    {

        $products = Recent::with('product')
            ->inRandomOrder()
            ->limit(8)
            ->get();

        return response()->api([
            "products" => (new ProductCollection($products))
        ]);
    }


    /**
     * get Product And Reviews Data
     */
    public function getProductAndReviewsData(Request $request)
    {

        $url = $request->query('url');
        $existingProduct = Product::where('url', $url)->first();
        if($existingProduct){
            $existingProduct->load(['website', 'reviews', 'brand']);
            return response()->api([
                'product' =>  new ProductResource($existingProduct),
            ]);
        }

        ReviewsHandlingJob::dispatch(new SaveProductData(), $url);
        set_time_limit(3000);
        $url = "http://127.0.0.1:5000/product-scraper?url=".$url;
        $response = Http::timeout(300000)->get($url);
        $data  = $response->json();

        return response()->api([
            "product"=>  $data,
        ]);
    }
}
