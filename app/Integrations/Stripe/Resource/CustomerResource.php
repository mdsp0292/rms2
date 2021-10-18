<?php

namespace App\Integrations\Stripe\Resource;

use App\Models\Account;
use App\Services\AccountService;
use Illuminate\Support\Facades\Log;
use Stripe\Collection;
use Stripe\Exception\ApiErrorException;

class CustomerResource extends AbstractResource
{
    /**
     * @param AccountResource $account
     * @return false|int
     */
    public function create(Account $account): false|int
    {
        $customerData = (new AccountService)->getAccountInfoFrForStripe($account);
        try {
            $result = $this->stripeClient->customers->create($customerData);
            if (empty($result->id)) {
                //this should never
                Log::error('Error creating account ID '.$account->id.' in stripe ',['result' => $result]);
                return false;
            }

            $account->stripe_id = $result->id;
            $account->save();
            return $result->id;

        } catch (ApiErrorException $e) {
            report($e);
            return false;
        }
    }

    /**
     * @param AccountResource $account
     * @return false|\Stripe\Customer
     */
    public function get(Account $account): bool|\Stripe\Customer
    {
        if (empty($account->stripe_id)) {
            return false;
        }

        try {
            return $this->stripeClient->customers->retrieve($account->stripe_id, []);
        } catch (ApiErrorException $e) {
            report($e);
            return false;
        }
    }

    /**
     * @return false|Collection
     */
    public function list(): Collection|bool
    {
        try {
            return $this->stripeClient->customers->all(['limit' => 10]);
        } catch (ApiErrorException $e) {
            report($e);
            return false;
        }
    }
}
