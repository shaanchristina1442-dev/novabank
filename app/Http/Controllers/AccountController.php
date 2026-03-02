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
    public function depositStore(Request $request, Account $account){
        $this->authorizeAccount($account);

        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        $account->increment('balance', $data['amount']);
        Transactions::create([
            'user_id' => auth()->id(),
            'account_id' => $account->id,
            'amount'=> $data['amount'],
            'type' => 'credit',
            'description' => $data['description'] ?? 'Deposit',
        ]);
        return back()->with('success', 'Deposit successful.');

    }
    public function withdrawStore(Request $request, Account $account){
        $this->authorizeAccount($account);

        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        if ($account->balance < $data['amount']){
            return back()->with('error', 'Insufficient funds.');
        }
        $account->decrement('balance', $data['amount']);
        Transactions::create([
            'user_id' => auth()->id(),
            'account_id' => $account->id,
            'amount' => $data['amount'],
            'type' => 'debit',
            'description' => $data['description'] ?? 'Withdrawal',
        ]);
        return back()->with('success', 'Withdrawal successful.');
    }
    public function transfer(Request $request, Account $account){
        $account = Account::where('id', '!=', $account->id)->get();
        return view('accounts.transfer', compact('account'));
    }
    public function transferStore(Request $request, Account $account){
        $request->validate([
            'to_account_id' => ['required', 'exists:accounts,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);
        $toAccount = Account::findOrFail($request->to_account_id);
        $amount = $request->amount;

        if ($account->balance < $amount){
            return back()->with('error', 'Insufficient funds.');
        }
        DB::transaction(function () use ($account, $toAccount, $amount) {
            $account->$balance -= $amount;
            $account->save();

            $toAccount->balance += $amount;
            $toAccount->save();
       
        });
        return redirect()->route('account.show', $account)
            ->with('success', 'Transfer complete');
        
    }
    private function authorizeAccount(Account $account): void{
        if ($account->user_id !== auth()->id()){
            abort(401);
        }

    }
}
