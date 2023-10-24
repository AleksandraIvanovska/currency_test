<?php

namespace App\Http\Controllers\CurrencyConversion\Models;

use App\Traits\UuidScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory, UuidScopeTrait;

    protected $table = 'currencies';
    public $timestamps=true;
    public $incrementing=true;

    protected $fillable = [
        'value',
        'description',
        'to_base_eur'
    ];

    protected $hidden = [
        'id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function sourceCurrencies()
    {
        return $this->hasMany(CurrencyConversion::class,'category_id');
    }

    public function targetCurrencies()
    {
        return $this->hasMany(CurrencyConversion::class,'category_id');
    }
}
