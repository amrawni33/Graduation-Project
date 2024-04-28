<?php

namespace App\QueryBuilders;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FavouriteIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Brand::query()->with([]);


        parent::__construct($query, $request);
        $this->allowedFilters(
            AllowedFilter::exact('id'),
            AllowedFilter::partial('brand_name'),
            AllowedFilter::partial('brand_icon'),
            AllowedFilter::partial('brand_url'),
        );
    }
}
