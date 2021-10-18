<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OpportunitiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'account_id'          => $this->account_id,
            'account_name'        => $this->account->name,
            'product_id'          => $this->product_id,
            'product_name'        => $this->product->name,
            'sales_stage'         => intval($this->sales_stage),
            'sales_stage_string'  => $this->sales_stage_string,
            'amount'              => $this->amount,
            'referral_percentage' => $this->referral_percentage,
            'referral_amount'     => $this->referral_amount,
            'referral_start_date' => $this->referral_start_date,
            'created_by'          => $this->created_by,
            'sale_start'          => $this->sale_start,
            'sale_end'            => $this->sale_end,
            'deleted_at'          => $this->deleted_at,
            'stripe_invoice_id'   => $this->stripe_invoice_id,
        ];
    }
}
