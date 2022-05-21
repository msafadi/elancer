<?php

use App\Facades\Currency;
use Illuminate\Support\Facades\App;

function currency($value) {
    App::make('currency')->formatCurrency($value, config('app.currency'));
    app('currency')->formatCurrency($value, config('app.currency'));
    
    return Currency::formatCurrency($value, config('app.currency'));
}