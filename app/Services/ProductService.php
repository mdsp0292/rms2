<?php

namespace App\Services;

use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Support\Facades\Request;

class ProductService
{
    /**
     * get list of products collection
     *
     * @return ProductCollection
     */
    public function getList(): ProductCollection
    {
        return new ProductCollection(
            Product::query()
                ->orderByName()
                ->filter(Request::only(['search']))
                ->paginate()
                ->appends(Request::all())
        );
    }
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
