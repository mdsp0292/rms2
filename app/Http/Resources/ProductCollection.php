<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return $this->collection->map(function ($product) {
            return [
                'id'              => $product->id,
                'name'            => $product->name,
                'amount'          => '$ ' . $product->amount,
                'reseller_amount' => '$ ' . $product->reseller_amount,
                'active'          => $product->active ? 'Yes' : 'No',
                'deleted_at'      => $product->deleted_at

            ];
        });
    }
}
