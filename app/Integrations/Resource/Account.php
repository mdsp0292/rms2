<?php

namespace App\Integrations\Resource;

use App\Models\User;
use App\Services\UserService;
use Stripe\Exception\ApiErrorException;

class Account extends AbstractResource
{
    /**
     * @param User $user
     * @return bool
     */
    public function createConnectAccount(User $user): bool
    {
        try {
            $data = (new UserService)->getUserInfoForForConnectedAccount($user);
            $result = $this->stripeClient->accounts->create($data);

            if(!empty($result->id)){
                $user->stripe_connect_id = $result->id;
                $user->save();
                return true;
            }
            return false;

        } catch (ApiErrorException $e) {
            report($e);
            return false;
        }
    }
}
