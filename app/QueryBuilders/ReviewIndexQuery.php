<?php

namespace App\QueryBuilders;

use App\Models\Review;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


class ReviewIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Review::query()
            ->with(['product']);
        parent::__construct($query, $request);

        $this->allowedFilters([
            AllowedFilter::exact('id'),
            AllowedFilter::exact('product_id'),
            AllowedFilter::partial('text'),
            AllowedFilter::partial('summarize'),
            AllowedFilter::partial('positivity'),
            AllowedFilter::partial('negativity'),
            AllowedFilter::partial('url'),
            AllowedFilter::partial('stars'),
        ]);
    }
}
