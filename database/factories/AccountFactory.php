<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'email' => $this->faker->companyEmail,
            'phone' => $this->faker->phoneNumber,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => 'VIC',
            'country' => 'AU',
            'post_code' => $this->faker->postcode,
        ];
    }
}
