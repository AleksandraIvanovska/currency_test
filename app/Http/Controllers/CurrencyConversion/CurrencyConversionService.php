<?php

namespace App\Http\Controllers\CurrencyConversion;

use App\Http\Controllers\CurrencyConversion\Models\Currency;
use App\Http\Controllers\CurrencyConversion\Models\CurrencyConversion;
use App\Http\Controllers\CurrencyConversion\Transformers\CurrencyConversionTransformer;
use App\Http\Controllers\External\FixerController;

class CurrencyConversionService
{

    protected $currencyConversionModel;
    protected $currencyModel;
    protected $fixerController;
    protected $currencyConversionTransformer;
    /**
     * CurrencyConversionService constructor.
     */
    public function __construct(FixerController $fixerController, CurrencyConversion $currencyConversionModel, Currency $currencyModel, CurrencyConversionTransformer $currencyConversionTransformer)
    {
        $this->fixerController = $fixerController;
        $this->currencyConversionModel = $currencyConversionModel;
        $this->currencyModel = $currencyModel;
        $this->currencyConversionTransformer = $currencyConversionTransformer;
    }

    public function getAllCurrencies()
    {
        return $this->currencyModel::select('id','value','description')->get();
    }

    public function covertCurrency(array $request)
    {
        $source_currency = $this->currencyModel::where('value', $request['source_currency'])->select('currencies.id', 'currencies.value', 'currencies.to_base_eur')->first();
        $target_currency = $this->currencyModel::where('value', $request['target_currency'])->select('currencies.id', 'currencies.value', 'currencies.to_base_eur')->first();
        $converted_amount = null;

        // Calculate the converted value
        if ('EUR' == $request['source_currency']) {
            $converted_amount = $request['value'] * $target_currency->to_base_eur;
        } else if ('EUR' == $request['target_currency']) {
            $converted_amount = $request['value'] / $source_currency->to_base_eur;
        } else {
            $converted_amount = ($request['value'] / $source_currency->to_base_eur)*$target_currency->to_base_eur;
        }

        // Save record to db
        $db_record = $this->currencyConversionModel::create([
            'source_currency_id' => $source_currency['id'],
            'target_currency_id' => $target_currency['id'],
            'source_currency_value' => $request['value'],
            'target_currency_value' => $converted_amount
        ]);

        // Return formatted with relevant information response
        return response()->json(['message' => 'Your currency conversion is successful: ' . $request['value']
        . $source_currency['value'] . ' is ' . round($converted_amount, 2) . $target_currency['value'],
            'data' => $db_record],201);
    }

    public function getAllCurrencyConversions()
    {
        $getAll = $this->currencyConversionModel->with([
                'sourceCurrency' => function ($query) {
                    $query->select('currencies.id', 'currencies.value', 'currencies.description');
                },
                'targetCurrency' => function ($query) {
                    $query->select('currencies.id', 'currencies.value', 'currencies.description');
                }
            ])->get();

        // If there are a lot of records we could implement pagination
        return $this->currencyConversionTransformer->transformHistoryCurrencyConversions($getAll);
    }

}
