<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favourites;
use App\Http\Requests\StoreFavouritesRequest;
use App\Http\Requests\UpdateFavouritesRequest;

class FavouritesController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $favourites = Favourites::all();
        return view('favourites.index', compact('favourites'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        // Assuming you have a form for creating favourites
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Assuming you have validation rules for user_id and product_id
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $favourite = Favourites::create($validatedData);
        return redirect()->route('favourites.index');
    }

    // Display the specified resource.
    public function show(Favourites $favourite)
    {
        return view('favourites.show', compact('favourite'));
    }

    // Show the form for editing the specified resource.
    public function edit(Favourites $favourite)
    {
        // Assuming you have a form for editing favourites
    }

    // Update the specified resource in storage.
    public function update(Request $request, Favourites $favourite)
    {
        // Assuming you have validation rules for user_id and product_id
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $favourite->update($validatedData);
        return redirect()->route('favourites.index');
    }

    // Remove the specified resource from storage.
    public function destroy(Favourites $favourite)
    {
        $favourite->delete();
        return redirect()->route('favourites.index');
    }
}
