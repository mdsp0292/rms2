<?php

namespace App\Lists;

class AccountsList
{
    public static function get(): array
    {
        return collect([
            [
                'label' => 'Name',
                'value' => 'name',
                'sort'  => false,
                'link'  => ['route' => 'accounts.edit', 'value' => 'id'],
            ],
            [
                'label' => 'Email',
                'value' => 'email',
                'sort'  => false,
                'link'  => false,

            ],
            [
                'label' => 'Phone',
                'value' => 'phone',
                'sort'  => false,
                'link'  => false,

            ],
            [
                'label' => 'Address',
                'value' => 'full_address',
                'sort'  => false,
                'link'  => false,

            ],
            [
                'label' => 'Created on',
                'value' => 'created_at',
                'sort'  => false,
                'link'  => false,

            ]
        ])->all();

    }
}
