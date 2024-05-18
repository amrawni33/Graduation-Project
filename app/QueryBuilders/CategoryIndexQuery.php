<?php

namespace App\QueryBuilders;

use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Category::query();

        parent::__construct($query, $request);
        $this->allowedFilters(
            AllowedFilter::exact('id'),
            AllowedFilter::partial('name'),
            AllowedFilter::partial('icon'),
            AllowedFilter::partial('url'),
        );
    }
}
