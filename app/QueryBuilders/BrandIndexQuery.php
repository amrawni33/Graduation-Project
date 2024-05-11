<?php

namespace App\QueryBuilders;

use App\Models\Brand;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BrandIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Brand::query();

        parent::__construct($query, $request);
        $this->allowedFilters(
            AllowedFilter::exact('id'),
            AllowedFilter::partial('name'),
            AllowedFilter::partial('icon'),
            AllowedFilter::partial('url'),
        );
    }
}
