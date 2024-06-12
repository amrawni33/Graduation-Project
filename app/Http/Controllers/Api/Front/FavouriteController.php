<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\Favourite;
use App\Http\Requests\StoreFavouriteRequest;
use App\Http\Requests\UpdateFavouriteRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\FavouriteCollection;
use App\Http\Resources\FavouriteResource;
use App\Http\Resources\ProductCollection;
use App\Models\User;
use App\QueryBuilders\FavouriteIndexQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, FavouriteIndexQuery $favouriteIndexQuery)
    {
        $request->validate([
            'per_page' => 'nullable|integer|gt:0'
        ]);

        $favourites = $favouriteIndexQuery->paginate($request->per_page ?? 10);

        return response()->api([
            "favourites" => (new FavouriteCollection($favourites))->response()->getData(true)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFavouriteRequest $request)
    {
        $validatedData = $request->validated();
        $favourite = Favourite::create($validatedData);
        $favourite->load(['product.brand', 'user', 'product.website']);
        return response()->api([
            'favourite' =>  new FavouriteResource($favourite),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Favourite $favourite)
    {
        $favourite->load(['product.brand', 'user', 'product.website']);
        return response()->api([
            'favourite' =>  new FavouriteResource($favourite),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFavouriteRequest $request, Favourite $favourite)
    {
        $validatedData = $request->validated();
        $favourite->update($validatedData);

        $favourite->load(['product.reviews', 'user']);
        return response()->api([
            'favourite' =>  new FavouriteResource($favourite),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favourite $favourite)
    {
        $favourite->delete();
        return response()->api();
    }

    /**
     * return user's favourites
     */
    public function userFavourites(User $user)
    {

        $user = Auth::user();
        $userFavourites = Favourite::query()->where("created_by", $user->id)->with('product')->paginate(10);
        return response()->api([
            "favourites" => (new FavouriteCollection($userFavourites))->response()->getData(true)
        ]);
    }
}
