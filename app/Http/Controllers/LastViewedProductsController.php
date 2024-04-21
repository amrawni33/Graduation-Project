<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Last_Viewed_Products;

class LastViewedProductsController extends Controller
{
    public function index()
    {
        // Logic to fetch all last viewed products
        $lastViewedProducts = Last_Viewed_Products::all();
        return response()->json($lastViewedProducts);
    }

    public function store(Request $request)
    {
        // Logic to store new last viewed product
        $request->validate([
            'view_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $lastViewedProduct = Last_Viewed_Products::create($request->all());

        return response()->json($lastViewedProduct, 201);
    }

    public function show(Last_Viewed_Products $lastViewedProduct)
    {
        // Logic to show a single last viewed product
        return response()->json($lastViewedProduct);
    }

    public function update(Request $request, Last_Viewed_Products $lastViewedProduct)
    {
        // Logic to update last viewed product
        $request->validate([
            'view_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $lastViewedProduct->update($request->all());

        return response()->json($lastViewedProduct, 200);
    }

    public function destroy(Last_Viewed_Products $lastViewedProduct)
    {
        // Logic to delete last viewed product
        $lastViewedProduct->delete();

        return response()->json(null, 204);
    }
}
