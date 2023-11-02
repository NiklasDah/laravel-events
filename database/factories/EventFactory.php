<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'name' => $faker->sentence,
            'description' => $faker->paragraph,
            'location' => $faker->optional()->address,
            'location_type' => $faker->randomElement(['Indoor', 'Outdoor']),
            'invite_only' => $faker->boolean,
            'max_users' => $faker->randomNumber(2),
            'start' => $faker->dateTimeBetween('now', '+1 year'),
            'end' => $faker->dateTimeBetween('now', '+2 years'),
        ];
    }
}
