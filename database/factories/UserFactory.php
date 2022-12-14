<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'username' => $this->faker->userName(),
      'role_id' => Role::USER,
      'last_name' => $this->faker->lastName(),
      'first_name' => $this->faker->firstName(),
      'email' => $this->faker->unique()->safeEmail(),
      'password' => Hash::make('secret'),
    ];
  }

  public function role ($role) {
    return $this->state(function (array $attributes) use ($role) {
      return [
        'role_id' => $role,
      ];
    });
  }

  /**
   * Indicate that the model's email address should be unverified.
   *
   * @return \Illuminate\Database\Eloquent\Factories\Factory
   */
  public function unverified()
  {
    return $this->state(function (array $attributes) {
      return [
        'email_verified_at' => null,
      ];
    });
  }
}
