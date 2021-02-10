<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OpportunitiesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map->only(
            'id',
            'name',
            'account',
            'sales_stage',
            'sales_stage_string',
            'referral_percentage',
            'referral_amount',
            'referral_start_date',
            'created_by',
            'sale_start',
            'sale_end',
            'created_at',
            'deleted_at'
        );
    }
}
