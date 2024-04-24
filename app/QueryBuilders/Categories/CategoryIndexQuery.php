<?php

namespace App\QueryBuilders\Categories;

use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Category::query()->with([]);


        parent::__construct($query, $request);
        $this->allowedFilters(
            AllowedFilter::exact('id'),
            AllowedFilter::partial('category_name'),
            AllowedFilter::partial('category_icon'),
            AllowedFilter::partial('category_url'),
        );
    }
}
