<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\Website;
use App\Http\Requests\StoreWebsiteRequest;
use App\Http\Requests\UpdateWebsiteRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\WebsiteCollection;
use App\Http\Resources\WebsiteResource;
use App\QueryBuilders\WebsiteIndexQuery;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, WebsiteIndexQuery $websiteIndexQuery)
    {
        $request->validate([
            'per_page' => 'nullable|integer|gt:0'
        ]);

        $websites = $websiteIndexQuery->paginate($request->per_page ?? 10);

        return response()->api([
            "websites" => (new WebsiteCollection($websites))->response()->getData(true)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWebsiteRequest $request)
    {
        $validatedData = $request->validated();
        $website = Website::create($validatedData);
        return response()->api([
            'website' =>  new WebsiteResource($website),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Website $website)
    {
        return response()->api([
            'website' =>  new WebsiteResource($website),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWebsiteRequest $request, Website $website)
    {
        $validatedData = $request->validated();
        $website->update($validatedData);
        return response()->api([
            'website' =>  new WebsiteResource($website),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Website $website)
    {
        $website->delete();
        return response()->api();
    }
}
