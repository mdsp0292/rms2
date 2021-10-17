<?php

namespace App\Integrations\Resource;

use App\Models\Account;
use App\Services\AccountService;
use Stripe\Exception\ApiErrorException;

class Customer extends AbstractResource
{
    /**
     * @param Account $account
     * @return false|int
     */
    public function create(Account $account): false|int
    {
        $customerData = (new AccountService)->getAccountInfoFrForStripe($account);
        try {
            $result = $this->stripeClient->customers->create($customerData);
            if(!empty($result->id)){
                $account->stripe_id = $result->id;
                $account->save();
            }
            return true;
        } catch (ApiErrorException $e) {
            report($e);
            return false;
        }
    }
}
