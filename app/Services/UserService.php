<?php

namespace App\Services;

use App\Http\Resources\UserCollection;
use App\Jobs\SendWelcomeEmailAndCreateConnectAccountJob;
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
        $newUser->type = $data['type'];
        $newUser->owner = 0;
        $newUser->save();

        SendWelcomeEmailAndCreateConnectAccountJob::dispatch($newUser)->afterCommit();

        return true;
    }

    /**
     * @param User $user
     * @return array
     */
    public function getUserInfoForForConnectedAccount(User $user):array
    {
        return [
            'type'         => config('services.stripe.connect_account_type'),
            'country'      => config('services.stripe.connect_account_country'),
            'email'        => $user->email,
            'capabilities' => [
                'card_payments'          => ['requested' => true],
                'transfers'              => ['requested' => true],
                'au_becs_debit_payments' => ['requested' => true],
            ],
            'metadata' => [
                'rms_user_id' => $user->id
            ]
        ];
    }
}
