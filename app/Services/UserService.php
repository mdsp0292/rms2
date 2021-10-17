<?php

namespace App\Services;

use App\Http\Resources\UserCollection;
use App\Mail\NewUserWelcomeEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;

class UserService
{
    /**
     * @return UserCollection
     */
    public function getList(): UserCollection
    {
        return new UserCollection(
            User::query()
                ->orderByName()
                ->filter(Request::only(['search']))
                ->paginate()
                ->appends(Request::all())
        );
    }

    /**
     * @param array $data
     * @return bool
     */
    public function createNewUser(array $data): bool
    {
        $newUser = new User();
        $newUser->first_name = $data['first_name'];
        $newUser->last_name = $data['last_name'];
        $newUser->email = $data['email'];
        $newUser->owner = $data['owner'];
        $newUser->save();

        //send email
        Mail::to($data['email'])->send(new NewUserWelcomeEmail($newUser));
        //create connected account in stripe

        return true;
    }
}
