<?php

namespace App\QueryBuilders;

use App\Models\Favourite;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


class FavouriteIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Favourite::query()
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
