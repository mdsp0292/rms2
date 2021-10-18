<?php

namespace App\Lists;

class ProductsList
{
    public static function get(): array
    {
        return collect([
            [
                'label' => 'Name',
                'value' => 'name',
                'sort'  => false,
                'link'  => ['route' => 'products.edit', 'value' => 'id'],
            ],
            [
                'label' => 'Amount',
                'value' => 'amount',
                'sort'  => false,
                'link'  => false,

            ],
            [
                'label' => 'Reseller amount',
                'value' => 'reseller_amount',
                'sort'  => false,
                'link'  => false,

            ],
            [
                'label' => 'Active',
                'value' => 'active',
                'sort'  => false,
                'link'  => false,

            ]
        ])->all();

    }
}
