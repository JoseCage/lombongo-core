<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Bank;

class BankController extends Controller
{
  public function index()
  {
    $banks = Bank::paginate(30);

    return response()->json($banks);
  }
}
