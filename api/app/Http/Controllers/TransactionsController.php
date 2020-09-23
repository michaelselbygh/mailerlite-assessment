<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function getAccountTransactions($id){
        # return transaction sent from or received into account 
        return Transaction::where('from', $id)->orWhere('to', $id)->get();
    }

    public function processTransaction(Request $request, $id){
        # get customer
        $fromCustomer = Account::find($id);
        $toCustomer = Account::find($request->to);

        # check if sending amount exceeds customers balance

        # reduce sending customer balance
        $fromCustomer->balance -= $request->amount;

        # increase receiving customer balance
        $toCustomer->balance += $request->amount;

        # insert transaction details
        $transaction = new Transaction;
        $transaction->from = $id;
        $transaction->to = $request->to;
        $transaction->amount = $request->amount;
        $transaction->details = $request->details;
        $transaction->save();

        # return updated transaction list
        return Transaction::where('from', $id)->orWhere('to', $id)->get();

    }
}
