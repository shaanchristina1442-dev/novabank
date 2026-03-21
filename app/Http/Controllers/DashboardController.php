<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;
use App\Models\Transactions;


class DashboardController extends Controller
{
    public function index(){

    $user = Auth::user();

    $accounts = Account::where('user_id', $user->id)->get();
    $accountsIds = $accounts->pluck('id');

    $totalBalance = $accounts->sum('balance');
    $accountsCount = $accounts->count();

    $recentTransactions = Transactions::whereIn('account_id', $accountsIds)
        ->latest()
        ->take(5)
        ->get();

    

    $recentCount = $recentTransactions->count();

    return view('dashboard', compact(
        'totalBalance',
        'accountsCount',
        'recentTransactions',
        'recentCount'

    ));
  }
    
}
