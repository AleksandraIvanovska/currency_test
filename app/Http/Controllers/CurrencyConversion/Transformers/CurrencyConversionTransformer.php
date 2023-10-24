<?php


namespace App\Http\Controllers\CurrencyConversion\Transformers;

use Carbon\Carbon;

class CurrencyConversionTransformer
{
    public function transformHistoryCurrencyConversions($conversions)
    {
        return $conversions->map(function ($item) {
            return [
                'source_currency_value' => $item->sourceCurrency->value,
                'source_currency_description' => $item->sourceCurrency->description,
                'source_currency_amount' => $item->source_currency_value,
                'target_currency_value' => $item->targetCurrency->value,
                'target_currency_description' => $item->targetCurrency->description,
                'target_currency_amount' => round($item->target_currency_value,2),
                'created_at' => Carbon::parse($item->created_at)->format('d M Y'),
            ];
        });
    }
}
