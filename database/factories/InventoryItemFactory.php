<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventoryItem>
 */
class InventoryItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'quantity' => fake()->numberBetween(0,100),
            'sku' => Str::random(10),
            'notification_sent' => fake()->boolean(50),
        ];
    }

    /**
     * Indicate that the model's notification sent should be false.
     *
     * @return $this a factory object for Inventory Item with the notification not being sent
     */
    public function notificationNotSent(): static {
        return $this->state(fn (array $attributes) => [
            'notification_sent' => false,
        ]);
    }
}
