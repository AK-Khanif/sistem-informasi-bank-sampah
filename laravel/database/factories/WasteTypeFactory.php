<?php

namespace Database\Factories;

use App\Models\WasteCategory;
use App\Models\WasteType;
use Illuminate\Database\Eloquent\Factories\Factory;

class WasteTypeFactory extends Factory
{
    protected $model = WasteType::class;

    public function definition(): array
    {
        return [
            'waste_category_id' => WasteCategory::factory(),
            'code' => strtoupper(fake()->unique()->bothify('???###')),
            'name' => fake()->unique()->word(),
            'unit' => fake()->randomElement(['kg', 'gram', 'pcs', 'liter', 'botol']),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
