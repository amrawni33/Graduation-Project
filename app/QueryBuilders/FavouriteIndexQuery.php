<?php

namespace App\QueryBuilders;

use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


class FavouriteIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $user = Auth::user();
        $query = Favourite::query()->where("created_by", $user->id)
            ->with(['product.brand', 'user', 'product.website']);
        parent::__construct($query, $request);

        $this->allowedFilters([
            AllowedFilter::exact('id'),
            AllowedFilter::exact('product_id'),
            AllowedFilter::scope('date_between'),
        ]);
    }
}
