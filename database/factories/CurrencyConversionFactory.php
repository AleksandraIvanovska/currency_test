<?php

namespace Database\Factories;

use App\Http\Controllers\CurrencyConversion\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Http\Controllers\CurrencyConversion\Models\CurrencyConversion;

class CurrencyConversionFactory extends Factory
{
    protected $model = CurrencyConversion::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'source_currency_id' => Currency::factory()->create()->id,
            'target_currency_id' => Currency::factory()->create()->id,
            'source_currency_value' => $this->faker->randomFloat(),
            'target_currency_value' => $this->faker->randomFloat()
        ];
    }
}
