<?php

namespace App\Lists;

class UsersList
{
    public static function get(): array
    {
        return collect([
            [
                'label' => 'Name',
                'value' => 'name',
                'sort'  => false,
                'link'  => ['route' => 'users.edit', 'value' => 'id'],
            ],
            [
                'label' => 'Email',
                'value' => 'email',
                'sort'  => false,
                'link'  => false,

            ],
            [
                'label' => 'Role',
                'value' => 'role',
                'sort'  => false,
                'link'  => false,

            ]
        ])->all();

    }
}
