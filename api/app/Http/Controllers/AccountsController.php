<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function getAccount($id){
        # return account if exists, else return null
        return Account::find($id);
    }
}
