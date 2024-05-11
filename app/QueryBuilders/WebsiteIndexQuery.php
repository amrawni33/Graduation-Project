<?php

namespace App\QueryBuilders;

use App\Models\Website;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


class WebsiteIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Website::query();
        parent::__construct($query, $request);

        $this->allowedFilters([
            AllowedFilter::exact('id'),
            AllowedFilter::partial('name'),
            AllowedFilter::partial('url'),
            AllowedFilter::partial('icon'),
        ]);
    }
}
