<?php

namespace App\Http\Services\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;


class SaveProductData {

    public function save($url){
        set_time_limit(3000);
        $url = "http://127.0.0.1:5000/scraper?url=".$url;
        $response = Http::timeout(300000)->get($url);
        $data  = $response->json();

        foreach ($data['reviews'] as &$review) {
            foreach ($review as $key => $value) {
                $review[$key] = $this->modifyValue($key, $value);
            }
        }
        try {
            DB::beginTransaction();

            $product = Product::create($data['product']);
            $product->reviews()->createMany($data['reviews']);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    private function modifyValue($key, $value)
    {
        // Example modifications based on key
        switch ($key) {
            case 'images':
                return json_encode($value); // Just an example of modifying the value
            default:
                return $value;
        }
    }

}
