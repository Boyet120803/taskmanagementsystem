<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'fname' => fake()->firstName(),
            'mname' => fake()->firstName(),
            'lname' => fake()->lastName(),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'address' => fake()->address(),
            'contact' => fake()->phoneNumber(),
            'birthdate' => fake()->date(),
            'age' => fake()->numberBetween(18, 65),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make(static::$password ??= fake()->password()), // password
            'role' => fake()->randomElement([0, 1, 2]) // 0 = admin, 1 = manager, 2 = user
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
