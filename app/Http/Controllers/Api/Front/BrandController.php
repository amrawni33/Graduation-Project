<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\Brand;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\BrandResource;
use App\QueryBuilders\BrandIndexQuery;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, BrandIndexQuery $brandIndexQuery)
    {
        $request->validate([
            'per_page' => 'nullable|integer|gt:0'
        ]);

        $brands = $brandIndexQuery->paginate($request->per_page ?? 10);

        return response()->api([
            "brands" => (new BrandCollection($brands))->response()->getData(true)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $validatedData = $request->validated();

        $brand = Brand::create($validatedData);
        return response()->api([
            'brand' => new BrandResource($brand),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return response()->api([
            'brand' => new BrandResource($brand),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $validatedData = $request->validated();
        $brand->update($validatedData);

        return response()->api([
            'brand' => new BrandResource($brand),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return response()->api();
    }

    /**
     * returns random brads
     */
    public function randomBrands()
    {
        $brands = Brand::inRandomOrder()->limit(1)->get();
        return response()->api([
            "brands" => (new BrandCollection($brands))
        ]);
    }
}
