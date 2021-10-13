<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AccountsCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return $this->collection->map->only(
            'id', 'name', 'email', 'phone', 'full_address', 'created_at','deleted_at'
        );
    }
}
