<?php

namespace App\Integrations\Stripe\Resource;

use App\Models\User;
use App\Services\UserService;
use Stripe\Account;
use Stripe\Collection;
use Stripe\Exception\ApiErrorException;

class AccountResource extends AbstractResource
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

            $user->stripe_connect_id = $result->id;
            $user->save();
            return true;


        } catch (ApiErrorException $e) {
            report($e);
            return false;
        }
    }

    /**
     * @param User $user
     * @return false|Account
     */
    public function get(User $user): Account|bool
    {
        if (empty($user->stripe_connect_id)) {
            return false;
        }

        try {
            return $this->stripeClient->accounts->retrieve($user->stripe_connect_id, []);

        } catch (ApiErrorException $e) {

            report($e);
            return false;
        }
    }

    /**
     * @return Collection|bool
     */
    public function list(): Collection|bool
    {
        try {
            return $this->stripeClient->accounts->all(['limit' => 10]);
        } catch (ApiErrorException $e) {
            report($e);
            return false;
        }
    }
}
