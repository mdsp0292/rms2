<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Account;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $user = User::factory()->create([
            //'account_id' => $account->id,
            'first_name' => 'Sai',
            'last_name' => 'Prasad',
            'email' => 'sai@buzzlink.com',
            'owner' => true,
        ]);

        //$account = Account::create(['name' => 'Buzzlink']);

        $accounts = Account::factory()->count(5)->create([
            'user_id' => 1
        ]);



        Contact::factory()->count(10)->create([
            'account_id' => 1
        ])->each(function (Contact  $contact) use ($accounts) {
            $contact->update(['account_id' => $accounts->random()->id]);
        });
    }
}
