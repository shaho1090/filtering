<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'family'=> $this->faker->lastName(),
            'mobile' => $this->faker->numerify("9#########"),
            'email' => $this->faker->unique()->safeEmail(),
            'national_code' => $this->faker->numerify("##########"),
            'birthday' => $this->faker->date(),
        ];
    }
}
