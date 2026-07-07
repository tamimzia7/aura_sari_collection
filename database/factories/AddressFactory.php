<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        return [
            'label' => fake()->randomElement(['Home', 'Office', 'Other']),
            'name' => fake()->name(),
            'phone' => '01'.fake()->numerify('########'),
            'address_line1' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'zip_code' => fake()->postcode(),
            'country' => 'Bangladesh',
            'is_default' => false,
            'type' => 'shipping',
        ];
    }
}
