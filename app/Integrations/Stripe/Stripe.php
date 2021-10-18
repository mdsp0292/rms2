<?php

namespace App\Integrations\Stripe;

use App\Integrations\Stripe\Resource\AccountResource;
use App\Integrations\Stripe\Resource\CustomerResource;
use App\Integrations\Stripe\Resource\InvoiceResource;
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
        return new CustomerResource($this->stripe);
    }

    public function account()
    {
        return new AccountResource($this->stripe);
    }


    public function invoive()
    {
        return new InvoiceResource($this->stripe);
    }
}
