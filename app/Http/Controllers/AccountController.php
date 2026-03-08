<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index(){
        $accounts = Account::where('user_id', auth()->id())->get();
        return view('accounts.index', compact('accounts'));
    }
    public function show(Account $account){
        $this->authorizeAccount($account);

        $accounts = Account::where('user_id', auth()->id())->get();

        $transactions = $account->transactions()->paginate(15);

        return view('accounts.show', compact('account', 'accounts', 'transactions'));
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
        return redirect()->route('accounts.index')->with('success', 'Account created.');

    }
    public function deposit(Request $request, Account $account){
        $this->authorizeAccount($account);

        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
        ]);
        $amount = round((float)$request->amount, 2);

        $account->increment('balance', $amount);

        Transactions::create([
            'user_id' => auth()->id(),
            'account_id'=> $account->id,
            'type' => 'credit',
            'amount' => $amount,
            'description'=> $request->input('description', 'Deposit.'),

        ]);
        return back()->with('success', 'deposit recieved');


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
            'user_id' => auth()->id(),
            'account_id' => $account->id,
            'type' => 'debit',
            'amount' => $amount,
            'description' => $request->input('description', 'withdrawn')

        ]);
        return back()->with('success', 'Withdrawal recieved');
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
        Transaction::create([
            'user_id' => auth()->id(),
            'account_id' => $account->id,
            'amount' => $data['amount'],
            'type' => 'debit',
            'description' => $data['description'] ?? 'Withdrawal',
        ]);
        return back()->with('success', 'Withdrawal successful.');
    }
    public function transfer(Request $request, Account $account){
        $this->authorizeAccount($account);
        return redirect()->route('accounts.show', $account);
    }
    public function transferStore(Request $request, Account $account){
        $this->authorizeAccount($account);

        $data = $request->validate([
            'to_account_id' => ['required', 'exists:accounts,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $toAccount = Account::findOrFail($data['to_account_id']);
        $amount = round((float) $data['amount'], 2);
        $description = $data['description'] ?? 'Transfer';

        if ($account->balance < $amount) {
            return back()->with('error', 'Insufficient funds.');
        }

        DB::transaction(function () use ($account, $toAccount, $amount, $description) {
            $account->decrement('balance', $amount);
            $toAccount->increment('balance', $amount);

            Transactions::create([
                'user_id'     => auth()->id(),
                'account_id'  => $account->id,
                'type'        => 'debit',
                'amount'      => $amount,
                'description' => $description,
            ]);
            Transactions::create([
                'user_id'     => $toAccount->user_id,
                'account_id'  => $toAccount->id,
                'type'        => 'credit',
                'amount'      => $amount,
                'description' => $description,
            ]);
        });

        return redirect()->route('accounts.show', $account)->with('success', 'Transfer complete.');
    }
    private function authorizeAccount(Account $account): void{
        if ($account->user_id !== auth()->id()){
            abort(401);
        }

    }
}
