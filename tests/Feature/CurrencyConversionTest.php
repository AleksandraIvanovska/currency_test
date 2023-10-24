<?php

namespace Tests\Feature;

use App\Http\Controllers\CurrencyConversion\Models\Currency;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrencyConversionTest extends TestCase
{
    use RefreshDatabase;

    protected $connection = 'sqlite';

    public function testCurrencyConversion()
    {
        // Create sample currency records
        $sourceCurrency = Currency::factory()->create();
        $targetCurrency = Currency::factory()->create();
        $value = 100;

        $data = [
            'source_currency' => $sourceCurrency->value,
            'target_currency' => $targetCurrency->value,
            'value' => $value,
        ];

        $response = $this->post('/api/currencies/covertCurrency', $data);

        // Check the response status
        $response->assertStatus(201);

        // Check if the currency conversion record was created in the database
        $this->assertDatabaseHas('currency_conversion', [
            'source_currency_id' => $sourceCurrency->id,
            'target_currency_id' => $targetCurrency->id,
            'source_currency_value' => $data['value'],
        ]);

        // Check the response content
        $response->assertJson([
            'message' => 'Your currency conversion is successful: ' . $value.$sourceCurrency->value . ' is ' . round($response['data']['target_currency_value'], 2) . $targetCurrency->value,
        ]);
    }

    public function testInvalidCurrencyConversionRequest()
    {
        $data = [
            'source_currency' => 'InvalidCurrency', // This currency does not exist in the 'currencies' table
            'target_currency' => 'AnotherInvalidCurrency', // This currency also does not exist
            'value' => 'NotAnInteger', // This is not an integer
        ];

        $response = $this->post('/api/currencies/covertCurrency', $data);

        $response->assertStatus(403); // Expecting a 403 Forbidden response status
        $response->assertJson([
            'source_currency' => ['The selected source currency is invalid.'],
            'target_currency' => ['The selected target currency is invalid.'],
            'value' => ['The value must be an integer.'],
        ]);
    }
}
