<?php

namespace Database\Factories;

use App\Models\Collector;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Collector>
 */
class CollectorFactory extends Factory
{
    protected $model = Collector::class;

    public function definition(): array
    {
        return [
            'collector_code' => fake()->unique()->regexify('PNG-[0-9]{6}'),
            'name' => fake()->company(),
            'email' => fake()->unique()->companyEmail(),
            'phone' => fake()->unique()->phoneNumber(),
            'address' => fake()->address(),
            'contact_person' => fake()->name(),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }
}
