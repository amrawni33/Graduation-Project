<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewCollection;
use App\Http\Resources\ReviewResource;
use App\QueryBuilders\ReviewIndexQuery;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ReviewIndexQuery $reviewIndexQuery)
    {
        $request->validate([
            'per_page' => 'nullable|integer|gt:0'
        ]);

        $reviews = $reviewIndexQuery->paginate($request->per_page ?? 10);

        return response()->api([
            "reviews" => (new ReviewCollection($reviews))->response()->getData(true)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $validatedData = $request->validated();
        $review = Review::create($validatedData);
        return response()->api([
            'review' =>  new ReviewResource($review),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return response()->api([
            'review' =>  new ReviewResource($review),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $validatedData = $request->validated();
        $review->update($validatedData);
        return response()->api([
            'review' =>  new ReviewResource($review),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return response()->api();
    }
}
