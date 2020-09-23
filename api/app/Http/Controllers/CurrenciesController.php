<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrenciesController extends Controller
{
    public function getCurrencies(){
        # Return all currencies
        return Currency::all();
    }
}
