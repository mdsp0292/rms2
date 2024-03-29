<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return $this->collection->map->only(
            'id', 'name', 'email', 'owner', 'photo', 'deleted_at'
        );
    }
}
