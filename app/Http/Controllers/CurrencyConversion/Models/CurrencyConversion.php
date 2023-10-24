<?php

namespace App\Http\Controllers\CurrencyConversion\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyConversion extends Model
{
    use HasFactory;

    protected $table = 'currency_conversion';
    public $timestamps=true;
    public $incrementing=true;

    protected $fillable = [
        'source_currency_id',
        'target_currency_id',
        'source_currency_value', //source_currency_amount variable would be more accurate
        'target_currency_value' //target_currency_amount variable would be more accurate
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function sourceCurrency()
    {
        return $this->belongsTo(Currency::class, 'source_currency_id');
    }

    public function targetCurrency()
    {
        return $this->belongsTo(Currency::class, 'target_currency_id');
    }

}
