<?php

namespace App\Integrations\Stripe\Resource;

use Stripe\StripeClient;

abstract class AbstractResource
{
    public function __construct(protected StripeClient $stripeClient)
    {
        //..
    }
}
