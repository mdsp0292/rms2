<?php

namespace App\Http\Resources;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use JsonSerializable;

class OpportunitiesCollection extends ResourceCollection
{
    /**
     * @param Request $request
     * @return Arrayable|Collection|JsonSerializable
     */
    public function toArray($request): Collection|JsonSerializable|Arrayable
    {
        return $this->collection->transform(function ($opportunity) {
            return [
                'id'                  => $opportunity->id,
                'name'                => $opportunity->name,
                'account'             => $opportunity->account,
                'sales_stage'         => $opportunity->sales_stage,
                'sales_stage_string'  => $opportunity->sales_stage_string,
                'referral_percentage' => $opportunity->referral_percentage,
                'referral_amount'     => '$' . $opportunity->referral_amount,
                'referral_start_date' => $opportunity->referral_start_date,
                'created_by'          => $opportunity->created_by,
                'sale_start'          => $opportunity->sale_start,
                'sale_end'            => $opportunity->sale_end,
                'created_at'          => $opportunity->created_at,
                'deleted_at'          => $opportunity->deleted_at
            ];
        });
    }
}
