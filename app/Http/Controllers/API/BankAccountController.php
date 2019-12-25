<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\BankAccount;

class BankAccountController extends Controller
{
    public function index()
    {
      $accounts = BankAccount::paginate();

      return response()->json($accounts);
    }
}
