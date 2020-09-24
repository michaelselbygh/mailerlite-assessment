<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionsController extends Controller
{
    public function getAccountTransactions($id){
        # get transactions sent from or received into account 
        $transactions = Transaction::where('from', $id)->orWhere('to', $id)->get();

        # format transactions for easy display, if transactions exist.
        if ($transactions) {
            $formattedTransactions = $this->formatTransactions($transactions, $id);
        }
        
        return response()->json([
            "code" => 200,
            "message" => "Transactions retrieved",
            "account" => Account::find($id),
            "transactions" => $formattedTransactions
        ]);
    }

    public function processTransaction(Request $request, $id){
        # get sending customer
        $fromCustomer = Account::find($id);

        # get receiving customer
        $toCustomer = Account::find($request->to);

        # check if sending amount exceeds customers balance
        if ($request->amount > $fromCustomer->balance) {
            # insufficient funds
            return response()->json([
                "code" => 400,
                "message" => "Insufficient funds"
            ]);
        }

        # reduce sending customer balance
        $fromCustomer->balance -= $request->amount;
        $fromCustomer->save();

        # increase receiving customer balance
        $toCustomer->balance += $request->amount;
        $toCustomer->save();

        # insert transaction details
        $transaction = new Transaction;
        $transaction->from = $id;
        $transaction->to = $request->to;
        $transaction->amount = $request->amount;
        $transaction->details = $request->details;
        $transaction->save();

        # return success message, account details and transactions
        return response()->json([
            "code" => 200,
            "message" => "Transaction processed successfully.",
            "account" => Account::find($id),
            "transactions" => $this->formatTransactions(Transaction::where('from', $id)->orWhere('to', $id)->get(), $id)
        ]);


    }

    public function formatTransactions($transactions, $id){

        for ($i=0; $i < sizeof($transactions); $i++) { 
            $formattedTransactions[$i]["id"] = $transactions[$i]["id"];
            $formattedTransactions[$i]["from"] = $transactions[$i]["from"];
            $formattedTransactions[$i]["to"] = $transactions[$i]["to"];
            $formattedTransactions[$i]["details"] = $transactions[$i]["details"];
            # defaulting currency to USD
            $formattedTransactions[$i]["amount"] = $formattedTransactions[$i]["from"] == $id? "- $ ".$transactions[$i]["amount"] : "$ ".$transactions[$i]["amount"];
            $formattedTransactions[$i]["processed"] = date('d-m-Y h:i:s A',strtotime($transactions[$i]["created_at"]));
        }

        return $formattedTransactions;
    }
}
