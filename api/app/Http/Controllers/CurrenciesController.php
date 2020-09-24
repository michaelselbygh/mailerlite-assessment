<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrenciesController extends Controller
{
    public function getCurrencies(){
        # Return all currencies
        return response()->json([
            "code" => 200,
            "message" => "Currencies retrieved",
            "currencies" => Currency::all()
        ]);
    }
}
