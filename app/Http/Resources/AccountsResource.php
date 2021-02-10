<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'street'     => $this->street,
            'city'       => $this->city,
            'state'      => $this->state,
            'country'    => $this->country,
            'post_code'  => $this->post_code,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
