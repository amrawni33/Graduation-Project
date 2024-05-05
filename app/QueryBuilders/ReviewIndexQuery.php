<?php

namespace App\QueryBuilders;

use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


class ReviewIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Product::query()
            ->with([]);
        parent::__construct($query, $request);

        $this->allowedFilters([
            AllowedFilter::exact('id'),
            AllowedFilter::partial('seller_name'),
            AllowedFilter::scope('seller_name'),
        ]);
    }
}
