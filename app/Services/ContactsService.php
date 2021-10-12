<?php

namespace App\Services;

use App\Http\Resources\ContactCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ContactsService
{
    public function getList()
    {
        return new ContactCollection(
            Auth::user()->account->contacts()
                ->with('organization')
                ->orderByName()
                ->filter(Request::only(['search', 'trashed']))
                ->paginate()
                ->appends(Request::all())
        );
    }
}
