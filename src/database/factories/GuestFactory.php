<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Guest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GuestFactory extends Factory
{
    protected $model = Guest::class;

    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $email = $this->faker->unique()->safeEmail();
        $phone = '+7' . $this->faker->numerify('##########');
        $countryId = Country::inRandomOrder()->value('id');

        return [
            'id' => Str::uuid7(now()),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'country_id' => $countryId,
        ];
    }
}
