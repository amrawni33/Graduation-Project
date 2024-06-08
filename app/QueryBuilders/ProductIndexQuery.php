<?php

namespace App\QueryBuilders;

use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


class ProductIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Product::query()
            ->with(['website', 'reviews', 'brand']);
        parent::__construct($query, $request);

        $this->allowedFilters([
            AllowedFilter::exact('id'),
            AllowedFilter::partial('name'),
            AllowedFilter::exact('price'),
            AllowedFilter::partial('url'),
            AllowedFilter::partial('average_rating'),
            AllowedFilter::exact('total_reviews'),
            AllowedFilter::partial('short_description'),
            AllowedFilter::partial('seller_name'),
            AllowedFilter::exact('brand_id'),
            AllowedFilter::exact('website_id'),
        ]);
    }
}
