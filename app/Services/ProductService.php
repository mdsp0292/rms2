<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    /**
     * @return array
     */
    public function getProductsListForSelect(): array
    {
        return Product::query()
            ->select('id', 'name', 'amount')
            ->get()->map(function ($product){
                return[
                    'value' => $product->id,
                    'label' => $product->name,
                    'amount' => $product->amount
                ];
            })->all();
    }
}
