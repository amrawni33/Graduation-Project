<?php

namespace App\QueryBuilders;

use App\Models\Recent;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


class RecentIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Recent::query()
            ->with(['product.reviews', 'user']);
        parent::__construct($query, $request);

        $this->allowedFilters([
            AllowedFilter::exact('id'),
            AllowedFilter::exact('created_by'),
            AllowedFilter::exact('updated_by'),
            AllowedFilter::exact('product_id'),
            AllowedFilter::scope('date_between'),
        ]);
    }
}
