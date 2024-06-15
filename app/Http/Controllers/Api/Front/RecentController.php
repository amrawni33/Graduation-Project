<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\Recent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecentRequest;
use App\Http\Requests\UpdateRecentRequest;
use App\Http\Resources\RecentCollection;
use App\Http\Resources\RecentResource;
use App\Models\User;
use App\QueryBuilders\RecentIndexQuery;
use Illuminate\Support\Facades\Auth;

class RecentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, RecentIndexQuery $recentIndexQuery)
    {
        $request->validate([
            'per_page' => 'nullable|integer|gt:0'
        ]);

        $recent = $recentIndexQuery->paginate($request->per_page ?? 10);

        return response()->api([
            "recent" => (new RecentCollection($recent))->response()->getData(true)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecentRequest $request)
    {
        $findRecent = Recent::where("product_id", $request->product_id)
            ->where("created_by", Auth::user()->id)
            ->first();
        if ($findRecent) {
            $this->destroy($findRecent);
        }
        $validatedData = $request->validated();
        $recent = Recent::create($validatedData);

        $recent->load(['product.brand', 'user', 'product.website']);
        return response()->api([
            'recent' =>  new RecentResource($recent),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Recent $recent)
    {
        $recent->load(['product.brand', 'user', 'product.website']);
        return response()->api([
            'recent' =>  new RecentResource($recent),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecentRequest $request, Recent $recent)
    {
        $validatedData = $request->validated();
        $recent->update($validatedData);

        $recent->load(['product.reviews', 'user']);
        return response()->api([
            'recent' =>  new RecentResource($recent),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recent $recent)
    {
        $recent->delete();
        return response()->api();
    }
}
