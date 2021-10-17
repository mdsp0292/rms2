<?php

namespace App\Integrations\Stripe;

use App\Integrations\Stripe\Resource\Account;
use App\Integrations\Stripe\Resource\Customer;
use Stripe\StripeClient;

class Stripe
{
    private StripeClient $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.key'));
    }


    public function customer()
    {
        return new Customer($this->stripe);
    }

    public function account()
    {
        return new Account($this->stripe);
    }
}
