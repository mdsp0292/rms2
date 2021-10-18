<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'amount'          => $this->amount,
            'reseller_amount' => $this->reseller_amount,
            'active'          => $this->active,
            'deleted_at'      => $this->deleted_at,
        ];
    }
}
