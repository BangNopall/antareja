<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\user;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = User::class;
    public function definition()
    {
        return [
            'team_id' => function () {
                return \App\Models\Team::factory()->create()->id;
            },
            'name' => $this->faker->name,
            'sekolah' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'nomor_hp' => $this->faker->numerify('##########'),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'is_admin' => false,
        ];
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_admin' => true,
            ];
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
