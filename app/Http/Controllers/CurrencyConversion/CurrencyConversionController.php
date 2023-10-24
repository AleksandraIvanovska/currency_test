<?php

namespace App\Http\Controllers\CurrencyConversion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyConversionController extends Controller
{
    protected $resourcesService;

    /**
     * ResourcesController constructor.
     */
    public function __construct(CurrencyConversionService $currencyConversionService)
    {
        $this->currencyConversionService = $currencyConversionService;
    }

    public function getAllCurrencies(Request $request)
    {
        return $this->currencyConversionService->getAllCurrencies();
    }

    public function covertCurrency(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'source_currency' => 'required|string|exists:currencies,value',
            'target_currency' => 'required|string|exists:currencies,value',
            'value' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(),403);
        }

        return $this->currencyConversionService->covertCurrency($request->all());
    }

    public function getAllCurrencyConversions(Request $request)
    {
        return $this->currencyConversionService->getAllCurrencyConversions();
    }
}
