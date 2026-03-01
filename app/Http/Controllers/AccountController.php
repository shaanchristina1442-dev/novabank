<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transactions;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(){
        $accounts = Account::where('user_id', auth()->id())->get();
        return view('accounts.index', compact('accounts'));
    }
    public function show(Account $account){
        $this->authorizeAccount($account);

        $transactions = $account->transactions()->paginate(15);

        return view('accounts.show', compact('account', 'transactions'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
        ]);
        Account::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'balance' => 0,
        ]);
        return redirect()->route('accounts.index')->width('success', 'Account created.');

    }
    public function deposit(Request $request, Account $account){
        $this->authorizeAccount($account);

        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
        ]);
        $amount = round((float)$request->amount, 2);

        Transactions::create([
            'account_id'=> $account->id(),
            'type' => 'deposit',
            'amount' => $amount,
            'description'=> $request->Input('description', 'Deposit.'),

        ]);
        return back()->width('success', 'deposit recieved');


    }
    public function withdraw(Request $request, Account $account){
        $this->authorizeAccount($account);

        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            
        ]);
        $amount = round((float)$request->amount, 2);
        if($account->balance < $amount){
            return back()->with('error', 'Insufficient funds');
        }
        $account->decrement('balance', $amount);

        Transactions::create([
            'account_id' => $account->id,
            'type' => 'withdrawal',
            'amount' => $amount,
            'description' => $request-Input('description', 'withdrawn')

        ]);
        return back()->with('sucess', 'Withdrawal recieved');
    }
    private function authorizeAccount(Account $account): void{
        if ($account->user_id !== auth()->id()){
            abort(401);
        }

    }
}
