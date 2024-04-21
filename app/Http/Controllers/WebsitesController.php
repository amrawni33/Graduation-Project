<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Websites;
use App\Http\Requests\StoreWebsitesRequest;
use App\Http\Requests\UpdateWebsitesRequest;

class WebsitesController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $websites = Websites::all();
        return view('websites.index', compact('websites'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        // Assuming you have a form for creating websites
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Assuming you have validation rules for website_name, URL, and product_id
        $validatedData = $request->validate([
            'website_name' => 'required|string',
            'URL' => 'required|url',
            'product_id' => 'required|exists:products,id',
        ]);

        $website = Websites::create($validatedData);
        return redirect()->route('websites.index');
    }

    // Display the specified resource.
    public function show(Websites $website)
    {
        return view('websites.show', compact('website'));
    }

    // Show the form for editing the specified resource.
    public function edit(Websites $website)
    {
        // Assuming you have a form for editing websites
    }

    // Update the specified resource in storage.
    public function update(Request $request, Websites $website)
    {
        // Assuming you have validation rules for website_name, URL, and product_id
        $validatedData = $request->validate([
            'website_name' => 'required|string',
            'URL' => 'required|url',
            'product_id' => 'required|exists:products,id',
        ]);

        $website->update($validatedData);
        return redirect()->route('websites.index');
    }

    // Remove the specified resource from storage.
    public function destroy(Websites $website)
    {
        $website->delete();
        return redirect()->route('websites.index');
    }
}
