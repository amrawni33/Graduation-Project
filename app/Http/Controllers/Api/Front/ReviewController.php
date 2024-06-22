<?php

namespace App\Http\Controllers\Api\Front;

use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewCollection;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\QueryBuilders\ReviewIndexQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

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
        $review->load(['product']);
        return response()->api([
            'review' =>  new ReviewResource($review),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $review->load(['product']);
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

        $review->load(['product']);
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

    /**
     * reviews analysis
     */
    public function productReviewsAnlysis(Request $request)
    {
        $productId = $request->query('product_id');
        $reviews = Review::query()->where("product_id", $productId)->get();
        $url= Product::where("id", $productId)->first()->url;
        $positiveSum = 0;
        $negativeSum = 0;
        $positiveCount = 0;
        $RatingCount = 0;
        $reviewsCount = 0;
        $collectionOfPositiveSummrize = [];
        $collectionOfNegativeSummrize = [];
        foreach ($reviews as $review) {
            if ($review->is_fake == 0) {
                $positiveSum += $review->positivity;
                $negativeSum += $review->negativity;
                $RatingCount += $review->rating;
                $positiveCount++;
                if ($review->positivity > $review->negativity) {
                    $collectionOfPositiveSummrize[] = $review->summarize;
                } else {
                    $collectionOfNegativeSummrize[] = $review->summarize;
                }
            }
            $reviewsCount++;
        }
        $averagePositive = $positiveCount > 0 ? $positiveSum / $positiveCount : 0;
        $averagenegative = $positiveCount > 0 ? $negativeSum / $positiveCount : 0;
        $newRating = $positiveCount > 0 ? $RatingCount / $positiveCount : 0;
        $fakePercentage = $positiveCount > 0 ? ($reviewsCount - $positiveCount)  / $reviewsCount : 0;

        $asin = $this->extractAsin($url);
        $url_chart = "https://charts.camelcamelcamel.com/us/{$asin}/amazon.png?force=1&zero=0&w=1063&h=549.5&desired=false&legend=1&ilt=1&tp=all&fo=0&lang=en";
        return response()->api([
            "positivity_average" => round($averagePositive, 2),
            "negativity_average" => round($averagenegative, 2),
            "rating_after_fake_filter" => $newRating,
            "fake_percentage" => $fakePercentage,
            "collectionOfPositiveSummrize" => $collectionOfPositiveSummrize,
            "collectionOfNegativeSummrize" => $collectionOfNegativeSummrize,
            "price_tracking_chart" => $url_chart,
        ]);
    }

    public function getProductReviews(Request $request)
    {
        $productId = $request->query('product_id');
        $reviews = Review::where("product_id", $productId)->paginate(10);

        return response()->api([
            "reviews" => (new ReviewCollection($reviews))->response()->getData(true)
        ]);
    }
    public function extractAsin($url)
    {
        // Define the regex pattern for ASIN
        $pattern = '/\/dp\/([A-Z0-9]{10})|\/gp\/product\/([A-Z0-9]{10})/';

        // Search for the pattern in the URL
        preg_match($pattern, $url, $matches);

        // Extract the ASIN from the match groups
        if (isset($matches[1]) && $matches[1]) {
            return $matches[1];
        } elseif (isset($matches[2]) && $matches[2]) {
            return $matches[2];
        } else {
            return null;
        }
    }
}
