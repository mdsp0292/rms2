<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes, HasFactory;

    public function users()
    {
        return $this->hasMany(User::class);
    }


    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
