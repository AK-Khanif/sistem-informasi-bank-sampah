<?php

namespace Database\Factories;

use App\Models\WastePrice;
use App\Models\WasteType;
use Illuminate\Database\Eloquent\Factories\Factory;

class WastePriceFactory extends Factory
{
    protected $model = WastePrice::class;

    public function definition(): array
    {
        return [
            'waste_type_id' => WasteType::factory(),
            'buy_price' => fake()->randomFloat(2, 500, 20000),
            'effective_date' => fake()->date(),
            'is_active' => true,
        ];
    }
}
