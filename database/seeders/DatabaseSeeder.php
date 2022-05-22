<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $adminUser = User::query()->where('email','mdsp0292@gmail.com')->first();
        if(!$adminUser)
        {
            $pass = 'Welcome!';
            $user = new User();
            $user->first_name = 'Sai';
            $user->last_name = 'Prasad';
            $user->email = 'mdsp0292@gmail.com';
            $user->password = $pass;
            $user->owner = 1;
            $user->type = User::USER_TYPE_ADMIN;
            $user->save();
            echo 'New Password is '.$pass;
        }
        else
        {
            echo 'Admin user already exists';
        }


        $accounts = Account::factory()->count(12)->create([
            'user_id' => 1
        ]);

    }
}
