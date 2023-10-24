<?php

namespace Tests\Feature;

use App\Http\Controllers\CurrencyConversion\Models\CurrencyConversion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrencyConversionsHistoryTest extends TestCase
{
    use RefreshDatabase;

    protected $connection = 'sqlite';
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCurrencyConversionsHistory()
    {
        // Create some test items
        CurrencyConversion::factory(5)->create();

        // Send a GET request to the route that lists conversions
        $response = $this->get('/api/currencies/conversions');

        // Assert a successful response
        $response->assertStatus(200);

        // Assert that the response contains these keys
        $response->assertJsonStructure([
            [
            'source_currency_value',
            'source_currency_description',
            'source_currency_amount',
            'target_currency_value',
            'target_currency_description',
            'target_currency_amount',
            'created_at'
        ]
        ]);
    }
}
