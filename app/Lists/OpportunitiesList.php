<?php

namespace App\Lists;

use Illuminate\Support\Facades\Auth;

class OpportunitiesList
{
    public static function get(): array
    {
        $collection = collect([
            [
                'label' => 'Name',
                'value' => 'name',
                'sort'  => false,
                'link'  => Auth::user()->isOwner() ? ['route' => 'opportunities.edit', 'value' => 'id'] : false,
            ],
            [
                'label' => 'Account',
                'value' => 'account',
                'sort'  => false,
                'link'  => false,

            ],
            [
                'label' => 'Sales Stage',
                'value' => 'sales_stage_string',
                'sort'  => false,
                'link'  => false,

            ],
            [
                'label' => 'Referral Start date',
                'value' => 'referral_start_date',
                'sort'  => false,
                'link'  => false,

            ],
            [
                'label' => 'Referral Amount',
                'value' => 'referral_amount',
                'sort'  => false,
                'link'  => false,

            ],
            [
                'label' => 'Sale Start',
                'value' => 'sale_start',
                'sort'  => false,
                'link'  => false,

            ],
            [
                'label' => 'Created on',
                'value' => 'created_at',
                'sort'  => false,
                'link'  => false,

            ]
        ]);

        return $collection->all();

    }
}
