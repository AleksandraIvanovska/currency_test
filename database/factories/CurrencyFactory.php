<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Http\Controllers\CurrencyConversion\Models\Currency;


class CurrencyFactory extends Factory
{
    protected $model = Currency::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => $this->faker->word,
            'description' => $this->faker->text,
            'to_base_eur' => $this->faker->randomFloat()
        ];
    }
}
