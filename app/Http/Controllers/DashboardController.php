<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

    $user = auth()->user();
    $accounts = $user->accounts;
    $totalBalance = $accounts->sum('balance');
    $accountsCount = $accounts->count();

    $recentTx = $user->transactions()->latest()->take(5)->get();

    return view('dashboard', compact (
        'totalBalance',
        'accountsCount',
        'recentTx'
    ));
    }
        
    
}
