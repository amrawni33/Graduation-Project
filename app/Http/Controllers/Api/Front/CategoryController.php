<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\QueryBuilders\CategoryIndexQuery;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CategoryIndexQuery $categoryIndexQuery)
    {
        $request->validate([
            'per_page' => 'nullable|integer|gt:0'
        ]);

        $categories = $categoryIndexQuery->paginate($request->per_page ?? 10);

        return response()->api([
            "categories" => (new CategoryCollection($categories))->response()->getData(true)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validatedData = $request->validated();

        $category = Category::create($validatedData);
        return response()->api([
            'category' => new CategoryResource($category),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->api([
            'category' => new CategoryResource($category),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validatedData = $request->validated();
        $category->update($validatedData);

        return response()->api([
            'category' => new CategoryResource($category),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->api();
    }
}
